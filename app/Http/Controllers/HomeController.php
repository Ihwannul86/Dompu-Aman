<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Forum;
use App\Models\Report;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('status', 'active')->count(),
            'total_articles' => Article::where('status', 'published')->count(),
            'total_forums' => Forum::count(),
            'total_reports' => Report::count(),
        ];

        return view('home', compact('stats'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // TODO: Send email or store in database

        return redirect()->route('home')->with('success', 'Pesan Anda telah dikirim!');
    }
}
