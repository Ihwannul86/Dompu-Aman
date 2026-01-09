<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Forum;
use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'latestArticles' => Article::published()
                                ->with('category', 'user')
                                ->latest('published_at')
                                ->take(6)
                                ->get(),
            'popularArticles' => Article::published()
                                ->with('category', 'user')
                                ->orderBy('view_count', 'desc')
                                ->take(3)
                                ->get(),
            'featuredForums' => Forum::active()
                                ->featured()
                                ->with('user', 'category')
                                ->take(4)
                                ->get(),
            'articleCategories' => Category::active()
                                    ->byType('article')
                                    ->ordered()
                                    ->get(),
            'statistics' => [
                'total_reports' => Report::count(),
                'resolved_reports' => Report::where('status', 'resolved')->count(),
                'active_users' => \App\Models\User::active()->count(),
                'published_articles' => Article::published()->count(),
            ]
        ];

        return view('home', $data);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        return redirect()->back()->with('success', 'Pesan Anda telah diterima! Terima kasih.');
    }
}
