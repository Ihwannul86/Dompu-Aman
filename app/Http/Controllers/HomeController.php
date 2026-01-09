<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Report;
use App\Models\Forum;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_articles' => Article::count(),
            'total_forums' => Forum::count(),
            'total_reports' => Report::count(),
        ];

        return view('home', compact('stats'));
    }

    public function about()
    {
        $stats = [
            'total_users' => User::count(),
            'total_articles' => Article::count(),
            'total_forums' => Forum::count(),
            'total_reports' => Report::count(),
        ];

        return view('about', compact('stats'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        // Handle contact form submission
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // TODO: Send email or save to database

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
