<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['category'])
            ->where('status', '!=', 'draft')
            ->latest()
            ->paginate(12);

        return view('reports.index', compact('reports'));
    }

    public function track(Request $request)
{
    $report = null;

    if ($request->has('report_number') && $request->report_number) {
        $report = Report::with(['category', 'user'])
            ->where('report_number', $request->report_number)
            ->first();
    }

    return view('reports.track', compact('report'));
}


    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        $categories = Category::where('type', 'report')
            ->orderBy('name')
            ->get();

        return view('reports.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['report_number'] = 'RPT-' . strtoupper(uniqid());
        $validated['status'] = 'pending';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('reports', 'public');
        }

        $report = Report::create($validated);

        return redirect()->route('reports.success', $report->report_number);
    }

    public function success($reportNumber)
    {
        $report = Report::where('report_number', $reportNumber)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('reports.success', compact('report'));
    }
}
