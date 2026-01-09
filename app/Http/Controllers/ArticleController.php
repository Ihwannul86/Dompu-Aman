<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['author', 'category'])
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        $categories = Category::where('type', 'article')
            ->orderBy('name')
            ->get();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        $article = Article::with(['author', 'category'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views
        $article->increment('views');

        // Get related articles
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();

        return view('articles.show', compact('article', 'relatedArticles'));
    }
}
