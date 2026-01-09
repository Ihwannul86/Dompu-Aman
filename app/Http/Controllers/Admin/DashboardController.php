<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Report;
use App\Models\Forum;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isModerator()) {
            abort(403, 'Unauthorized');
        }

        $data = [
            'total_users' => User::count(),
            'total_reports' => Report::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'resolved_reports' => Report::where('status', 'resolved')->count(),
            'total_articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'total_forums' => Forum::count(),
            'active_forums' => Forum::active()->count(),

            'recent_reports' => Report::with('category', 'user')
                                ->latest()
                                ->take(10)
                                ->get(),

            'recent_users' => User::latest()
                                ->take(5)
                                ->get(),

            'popular_articles' => Article::published()
                                    ->orderBy('view_count', 'desc')
                                    ->take(5)
                                    ->get(),

            'report_statistics' => $this->getReportStatistics(),
            'user_growth' => $this->getUserGrowth(),
        ];

        return view('admin.dashboard', $data);
    }

    private function getReportStatistics()
    {
        $last30Days = Report::where('created_at', '>=', Carbon::now()->subDays(30))
                           ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                           ->groupBy('date')
                           ->orderBy('date')
                           ->get();

        return [
            'labels' => $last30Days->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M')),
            'data' => $last30Days->pluck('count'),
        ];
    }

    private function getUserGrowth()
    {
        $last6Months = User::where('created_at', '>=', Carbon::now()->subMonths(6))
                          ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                          ->groupBy('year', 'month')
                          ->orderBy('year')
                          ->orderBy('month')
                          ->get();

        return [
            'labels' => $last6Months->map(fn($item) => Carbon::create($item->year, $item->month)->format('M Y')),
            'data' => $last6Months->pluck('count'),
        ];
    }
}
