<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display listing of published articles
     */
    public function index(Request $request)
    {
        $query = Article::with(['user', 'category'])
            ->published();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->popular();
                break;
            case 'oldest':
                $query->orderBy('published_at', 'asc');
                break;
            default:
                $query->recent();
                break;
        }

        $articles = $query->paginate(12);

        // Get categories for filter
        $categories = Category::where('type', 'article')
            ->orWhereNull('type')
            ->withCount('articles')
            ->get();

        return view('articles.index', compact('articles', 'categories'));
    }

    /**
     * Display single article
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->with(['user', 'category'])
            ->firstOrFail();

        // Check if published (allow admin to preview)
        if ($article->status !== 'published' && (!auth()->check() || auth()->user()->role !== 'admin')) {
            abort(404);
        }

        // Increment views
        $article->increment('views');
        $article->increment('view_count');

        // Get related articles (same category, exclude current)
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->published()
            ->limit(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }
}
