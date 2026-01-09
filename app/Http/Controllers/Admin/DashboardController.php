<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Article;
use App\Models\Forum;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Manual admin check
        if (!in_array(auth()->user()->role, ['admin', 'moderator'])) {
            abort(403, 'Unauthorized action.');
        }

        // Statistics
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_articles' => Article::count(),
            'total_forums' => Forum::count(),
            'total_reports' => Report::count(),

            'pending_reports' => Report::where('status', 'pending')->count(),
            'active_users' => User::where('status', 'active')->count(),
            'published_articles' => Article::where('status', 'published')->count(),
        ];

        // Recent data
        $recentReports = Report::with(['user', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        $recentUsers = User::latest()
            ->limit(5)
            ->get();

        $recentArticles = Article::with('author')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReports', 'recentUsers', 'recentArticles'));
    }
}
