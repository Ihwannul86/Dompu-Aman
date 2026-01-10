<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['category', 'user'])
            ->latest()
            ->paginate(12);

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $this->middleware('auth');

        $categories = Category::where('type', 'report')
            ->orderBy('name')
            ->get();

        return view('reports.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'incident_type' => 'nullable|string|max:255',
            'description' => 'required|string|min:20',
            'location' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'date' => 'required|date|before_or_equal:today',
            'time' => 'nullable|date_format:H:i',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_anonymous' => 'nullable|boolean',
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

        // Prepare report data
        $reportData = [
            'report_number' => $reportNumber,
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],

            // Map form fields to database fields
            'incident_type' => $validated['incident_type'] ?? 'umum',
            'incident_description' => $validated['description'],
            'incident_location' => $validated['location'],
            'incident_address' => $validated['address'] ?? null,
            'incident_date' => $validated['date'],
            'incident_time' => $validated['time'] ?? null,

            // Evidence
            'evidence_files' => !empty($evidenceFiles) ? json_encode($evidenceFiles) : null,

            // Default values
            'status' => 'pending',
            'priority' => 'medium',
            'severity' => 'moderate',
            'is_anonymous' => $validated['is_anonymous'] ?? false,
        ];

        // Create report
        $report = Report::create($reportData);

        // Redirect to success page
        return redirect()->route('reports.success', $report->report_number)
            ->with('success', 'Laporan berhasil dikirim!');
    }

    public function success($reportNumber)
    {
        $report = Report::where('report_number', $reportNumber)->firstOrFail();

        return view('reports.success', compact('report'));
    }

    public function track(Request $request)
    {
        $report = null;

        if ($request->filled('report_number')) {
            $report = Report::with(['category', 'statusHistories.user'])
                ->where('report_number', $request->report_number)
                ->first();
        }

        return view('reports.track', compact('report'));
    }

    public function show($id)
    {
        $report = Report::with(['category', 'user', 'statusHistories.user'])
            ->findOrFail($id);

        // Check if user can view this report
        if ($report->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        return view('reports.show', compact('report'));
    }
}
