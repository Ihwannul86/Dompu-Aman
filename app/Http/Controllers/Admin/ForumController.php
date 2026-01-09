<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Forum::with('user', 'category');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $forums = $query->latest()->paginate(15);

        return view('admin.forums.index', compact('forums'));
    }

    public function show(string $id)
    {
        $forum = Forum::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.forums.show', compact('forum'));
    }

    public function edit(string $id)
    {
        $forum = Forum::findOrFail($id);
        return view('admin.forums.edit', compact('forum'));
    }

    public function update(Request $request, string $id)
    {
        $forum = Forum::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:active,locked,hidden',
            'is_pinned' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $forum->update($validated);

        return redirect()->route('admin.forums.show', $forum->id)
                        ->with('success', 'Forum berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $forum = Forum::findOrFail($id);
        $forum->delete();

        return redirect()->route('admin.forums.index')
                        ->with('success', 'Forum berhasil dihapus!');
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
