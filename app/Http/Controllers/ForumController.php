<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::with(['user'])
            ->where('status', 'active')
            ->withCount('comments')
            ->latest()
            ->paginate(12);

        return view('forums.index', compact('forums'));
    }

    public function show($slug)
    {
        $forum = Forum::with(['user', 'comments.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $forum->increment('views');

        return view('forums.show', compact('forum'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu');
        }

        return view('forums.create');
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        $validated['status'] = 'active';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('forums', 'public');
        }

        $forum = Forum::create($validated);

        return redirect()->route('forums.show', $forum->slug)
            ->with('success', 'Forum berhasil dibuat!');
    }

    public function edit($slug)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $forum = Forum::where('slug', $slug)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('forums.edit', compact('forum'));
    }

    public function update(Request $request, $slug)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $forum = Forum::where('slug', $slug)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($forum->image) {
                \Storage::disk('public')->delete($forum->image);
            }
            $validated['image'] = $request->file('image')->store('forums', 'public');
        }

        $forum->update($validated);

        return redirect()->route('forums.show', $forum->slug)
            ->with('success', 'Forum berhasil diperbarui!');
    }

    public function destroy($slug)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $forum = Forum::where('slug', $slug)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Delete image if exists
        if ($forum->image) {
            \Storage::disk('public')->delete($forum->image);
        }

        $forum->delete();

        return redirect()->route('forums.index')
            ->with('success', 'Forum berhasil dihapus!');
    }

    public function storeComment(Request $request, $slug)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $forum = Forum::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $forum->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
