<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    public function create()
    {
        $categories = Category::where('type', 'article')->get();
        if ($categories->isEmpty()) {
            $categories = Category::all();
        }
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'article_type' => 'required|in:internal,external',
            'featured_image' => 'required|image|max:5120', // WAJIB untuk semua tipe
            'status' => 'required|in:draft,published',
        ];

        // Conditional validation based on article type
        if ($request->article_type === 'external') {
            $rules['external_url'] = 'required|url|max:500';
        } else {
            $rules['title'] = 'required|string|max:255';
            $rules['content'] = 'required|string';
            $rules['excerpt'] = 'nullable|string|max:500';
        }

        $validated = $request->validate($rules);

        // Set user_id
        $validated['user_id'] = auth()->id();

        // Handle EXTERNAL article
        if ($validated['article_type'] === 'external') {
            // Fetch data from URL
            $articleData = $this->fetchArticleFromUrl($validated['external_url']);

            // Set title from fetched data or from URL
            $validated['title'] = $articleData['title'] ?? $this->extractTitleFromUrl($validated['external_url']);

            // Set excerpt from fetched data
            $validated['excerpt'] = $articleData['description'] ?? 'Artikel dari sumber eksternal';

            // Set content as excerpt (karena konten asli ada di URL eksternal)
            $validated['content'] = $validated['excerpt'];

            // Extract source name from URL
            $validated['source_name'] = $this->extractSourceName($validated['external_url']);

            // Generate slug
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        } else {
            // Handle INTERNAL article
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();

            // Auto-generate excerpt if empty
            if (empty($validated['excerpt'])) {
                $validated['excerpt'] = Str::limit(strip_tags($validated['content']), 200);
            }
        }

        // Handle featured image upload (WAJIB untuk semua)
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        // Set published_at for published articles
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect('/admin/articles')->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Fetch article data from URL using HTTP request
     */
    private function fetchArticleFromUrl($url)
    {
        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                $html = $response->body();

                // Extract Open Graph meta tags
                $title = $this->extractMetaTag($html, 'og:title')
                      ?? $this->extractMetaTag($html, 'twitter:title')
                      ?? $this->extractTitleTag($html);

                $description = $this->extractMetaTag($html, 'og:description')
                            ?? $this->extractMetaTag($html, 'twitter:description')
                            ?? $this->extractMetaTag($html, 'description');

                return [
                    'title' => $title,
                    'description' => $description,
                ];
            }
        } catch (\Exception $e) {
            // If fetch fails, return null
            \Log::error('Failed to fetch article: ' . $e->getMessage());
        }

        return ['title' => null, 'description' => null];
    }

    /**
     * Extract meta tag content from HTML
     */
    private function extractMetaTag($html, $property)
    {
        // Try property attribute
        if (preg_match('/<meta\s+property=["\']' . preg_quote($property, '/') . '["\']\s+content=["\'](.*?)["\']/i', $html, $matches)) {
            return html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
        }

        // Try name attribute
        if (preg_match('/<meta\s+name=["\']' . preg_quote($property, '/') . '["\']\s+content=["\'](.*?)["\']/i', $html, $matches)) {
            return html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
        }

        return null;
    }

    /**
     * Extract title from <title> tag
     */
    private function extractTitleTag($html)
    {
        if (preg_match('/<title>(.*?)<\/title>/i', $html, $matches)) {
            return html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8');
        }
        return null;
    }

    /**
     * Extract title from URL if fetch fails
     */
    private function extractTitleFromUrl($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $segments = array_filter(explode('/', $path));
        $lastSegment = end($segments);

        // Convert URL slug to title
        return ucwords(str_replace(['-', '_'], ' ', $lastSegment));
    }

    /**
     * Extract source name from URL
     */
    private function extractSourceName($url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        $host = str_replace('www.', '', $host);

        // Remove TLD
        $parts = explode('.', $host);
        if (count($parts) > 1) {
            array_pop($parts);
            $host = implode('.', $parts);
        }

        return ucfirst($host);
    }

    public function index(Request $request)
    {
        $articles = Article::with('category', 'user')->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function show(string $id)
    {
        $article = Article::with('category', 'user')->findOrFail($id);
        return view('admin.articles.show', compact('article'));
    }

    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        $rules = [
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:categories,id',
        ];

        $validated = $request->validate($rules);
        $article->update($validated);

        return redirect('/admin/articles')->with('success', 'Artikel berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect('/admin/articles')->with('success', 'Artikel berhasil dihapus!');
    }
}
