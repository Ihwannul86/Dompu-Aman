<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Report::with('category', 'user', 'assignedUser');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('report_number', 'like', "%{$search}%")
                  ->orWhere('incident_type', 'like', "%{$search}%")
                  ->orWhere('incident_location', 'like', "%{$search}%");
            });
        }

        $reports = $query->latest()->paginate(15);

        return view('admin.reports.index', compact('reports'));
    }

    public function show(string $id)
    {
        $report = Report::with(['category', 'user', 'assignedUser', 'statusHistories.user'])
                       ->findOrFail($id);

        return view('admin.reports.show', compact('report'));
    }

    public function edit(string $id)
    {
        $report = Report::findOrFail($id);
        $moderators = User::whereIn('role', ['admin', 'moderator'])->get();

        return view('admin.reports.edit', compact('report', 'moderators'));
    }

    public function update(Request $request, string $id)
    {
        $report = Report::findOrFail($id);
        $oldStatus = $report->status;

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewing,investigating,resolved,rejected,closed',
            'priority' => 'required|in:low,medium,high,urgent',
            'severity' => 'required|in:minor,moderate,serious,critical',
            'assigned_to' => 'nullable|exists:users,id',
            'admin_notes' => 'nullable|string',
            'resolution_notes' => 'nullable|string',
        ]);

        if ($validated['status'] === 'resolved') {
            $validated['resolved_at'] = now();
        }

        $report->update($validated);

        // Create status history if status changed
        if ($oldStatus !== $validated['status']) {
            $report->statusHistories()->create([
                'user_id' => auth()->id(),
                'from_status' => $oldStatus,
                'to_status' => $validated['status'],
                'notes' => $request->admin_notes ?? 'Status diubah oleh admin',
            ]);
        }

        return redirect()->route('admin.reports.show', $report->id)
                        ->with('success', 'Laporan berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.reports.index')
                        ->with('success', 'Laporan berhasil dihapus!');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }
}
