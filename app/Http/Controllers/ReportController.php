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
        return view('reports.index');
    }

    public function create()
    {
        $categories = Category::active()->byType('report')->ordered()->get();
        return view('reports.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'is_anonymous' => 'boolean',
            'reporter_name' => 'required_if:is_anonymous,false|nullable|string|max:255',
            'reporter_phone' => 'nullable|string|max:20',
            'reporter_email' => 'nullable|email',
            'incident_type' => 'required|string|max:255',
            'incident_description' => 'required|string',
            'incident_location' => 'required|string|max:255',
            'incident_address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'incident_date' => 'required|date',
            'incident_time' => 'nullable|date_format:H:i',
            'victim_info' => 'nullable|array',
            'perpetrator_info' => 'nullable|array',
            'witness_info' => 'nullable|array',
            'evidence_files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
        ]);

        $validated['report_number'] = Report::generateReportNumber();
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        $validated['priority'] = 'medium';
        $validated['severity'] = 'moderate';

        if ($request->hasFile('evidence_files')) {
            $files = [];
            foreach ($request->file('evidence_files') as $file) {
                $path = $file->store('reports/evidence', 'public');
                $files[] = [
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ];
            }
            $validated['evidence_files'] = $files;
        }

        $report = Report::create($validated);

        $report->statusHistories()->create([
            'user_id' => auth()->id(),
            'from_status' => 'new',
            'to_status' => 'pending',
            'notes' => 'Laporan baru dibuat',
        ]);

        return redirect()->route('reports.success', $report->report_number)
                        ->with('success', 'Laporan berhasil dikirim!');
    }

    public function success($reportNumber)
    {
        $report = Report::where('report_number', $reportNumber)->firstOrFail();

        if (!auth()->check() || (auth()->id() !== $report->user_id && !auth()->user()->isAdmin())) {
            abort(403);
        }

        return view('reports.success', compact('report'));
    }

    public function track(Request $request)
    {
        $report = null;

        if ($request->filled('report_number')) {
            $report = Report::where('report_number', $request->report_number)
                           ->with('category', 'statusHistories.user')
                           ->first();
        }

        return view('reports.track', compact('report'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
