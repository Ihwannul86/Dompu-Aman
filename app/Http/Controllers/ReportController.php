<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['category', 'user'])
            ->whereIn('status', ['pending', 'reviewing', 'investigating', 'resolved', 'closed'])
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
            'category_id' => 'required|exists:categories,id',
            'incident_type' => 'nullable|string|max:255',
            'description' => 'required|string|min:20',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'date' => 'required|date|before_or_equal:today',
            'time' => 'nullable|date_format:H:i',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Generate unique report number
        $reportNumber = 'RPT-' . strtoupper(uniqid());

        // Handle image upload
        $evidenceFiles = [];
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reports', 'public');
            $evidenceFiles[] = [
                'type' => 'image',
                'path' => $path,
                'filename' => $request->file('image')->getClientOriginalName(),
            ];
        }

        // Create report with correct field mapping
        $report = Report::create([
            'report_number' => $reportNumber,
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],

            // Map form fields to database columns
            'incident_type' => $validated['incident_type'] ?? 'umum',
            'incident_description' => $validated['description'],
            'incident_location' => $validated['location'],
            'incident_address' => $validated['address'] ?? null,
            'incident_date' => $validated['date'],
            'incident_time' => $validated['time'] ?? null,

            // Evidence files as JSON
            'evidence_files' => !empty($evidenceFiles) ? json_encode($evidenceFiles) : null,

            // Default status values
            'status' => 'pending',
            'priority' => 'medium',
            'severity' => 'moderate',
            'is_anonymous' => false,
        ]);

        return redirect()->route('reports.success', $report->report_number)
            ->with('success', 'Laporan berhasil dikirim!');
    }

    public function success($reportNumber)
    {
        $report = Report::where('report_number', $reportNumber)
            ->with('category')
            ->firstOrFail();

        // Allow user to see their own report or if report is not anonymous
        if ($report->user_id !== auth()->id() && !$report->is_anonymous) {
            abort(403, 'Akses tidak diizinkan');
        }

        return view('reports.success', compact('report'));
    }
}
