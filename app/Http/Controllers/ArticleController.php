<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::published()->with('category', 'user');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort', 'latest');
        if ($sortBy === 'popular') {
            $query->orderBy('view_count', 'desc');
        } else {
            $query->latest('published_at');
        }

        $articles = $query->paginate(12);
        $categories = Category::active()->byType('article')->ordered()->get();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        $article = Article::published()
                    ->with('category', 'user')
                    ->where('slug', $slug)
                    ->firstOrFail();

        $article->increment('view_count');

        $relatedArticles = Article::published()
                            ->where('category_id', $article->category_id)
                            ->where('id', '!=', $article->id)
                            ->take(3)
                            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
