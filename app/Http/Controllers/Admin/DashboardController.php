<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use App\Models\Article;
use App\Models\Forum;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total counts
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalReports = Report::count();
        $totalArticles = Article::count();
        $totalForums = Forum::count();

        // Active users (logged in within last 30 days)
        $activeUsers = User::where('role', '!=', 'admin')
            ->where('last_login_at', '>=', Carbon::now()->subDays(30))
            ->count();

        // Published articles
        $publishedArticles = Article::where('status', 'published')->count();

        // Active forums
        $activeForums = Forum::where('status', 'active')->count();

        // Recent reports (last 10)
        $recentReports = Report::with(['user', 'category'])
            ->latest()
            ->take(10)
            ->get();

        // Report statistics by status
        $reportStats = [
            'pending' => Report::where('status', 'pending')->count(),
            'verified' => Report::where('status', 'verified')->count(),
            'in_progress' => Report::where('status', 'in_progress')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
            'rejected' => Report::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalReports',
            'totalArticles',
            'publishedArticles',
            'totalForums',
            'activeForums',
            'recentReports',
            'reportStats'
        ));
    }
}
