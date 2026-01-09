<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ForumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Forum::active()->with('user', 'category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'commented':
                $query->orderBy('comment_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $forums = $query->paginate(15);
        $categories = Category::active()->byType('forum')->ordered()->get();
        $pinnedForums = Forum::active()->pinned()->take(3)->get();

        return view('forums.index', compact('forums', 'categories', 'pinnedForums'));
    }

    public function create()
    {
        $categories = Category::active()->byType('forum')->ordered()->get();
        return view('forums.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'tags' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        $validated['status'] = 'active';

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('forums/images', 'public');
                $images[] = $path;
            }
            $validated['images'] = $images;
        }

        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        $forum = Forum::create($validated);

        return redirect()->route('forums.show', $forum->slug)
                        ->with('success', 'Forum berhasil dibuat!');
    }

    public function show($slug)
    {
        $forum = Forum::active()
                    ->with('user', 'category')
                    ->where('slug', $slug)
                    ->firstOrFail();

        $forum->increment('view_count');

        $comments = $forum->comments()
                         ->approved()
                         ->parent()
                         ->with(['user', 'replies.user'])
                         ->latest()
                         ->paginate(20);

        return view('forums.show', compact('forum', 'comments'));
    }

    public function edit($slug)
    {
        $forum = Forum::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $forum->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::active()->byType('forum')->ordered()->get();
        return view('forums.edit', compact('forum', 'categories'));
    }

    public function update(Request $request, $slug)
    {
        $forum = Forum::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $forum->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'tags' => 'nullable|string',
        ]);

        if ($validated['title'] !== $forum->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        }

        if ($request->hasFile('images')) {
            if ($forum->images) {
                foreach ($forum->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('forums/images', 'public');
                $images[] = $path;
            }
            $validated['images'] = $images;
        }

        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        $forum->update($validated);

        return redirect()->route('forums.show', $forum->slug)
                        ->with('success', 'Forum berhasil diupdate!');
    }

    public function destroy($slug)
    {
        $forum = Forum::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $forum->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($forum->images) {
            foreach ($forum->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $forum->delete();

        return redirect()->route('forums.index')
                        ->with('success', 'Forum berhasil dihapus!');
    }

    public function storeComment(Request $request, $slug)
    {
        $forum = Forum::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:forum_comments,id',
        ]);

        $validated['forum_id'] = $forum->id;
        $validated['user_id'] = auth()->id();
        $validated['is_approved'] = true;

        ForumComment::create($validated);

        $forum->increment('comment_count');

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
