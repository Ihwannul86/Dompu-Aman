@extends('layouts.admin')

@section('title', 'Kelola Artikel - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Artikel</h1>
            <p class="text-gray-600 mt-1">Kelola artikel edukasi untuk masyarakat</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">
                <i class="fas fa-filter mr-2"></i>
                Filter
            </button>
            <a href="{{ url('/admin/articles/create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Buat Artikel
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Artikel</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $articles->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-newspaper text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Published</p>
                    <p class="text-2xl font-bold text-green-600">{{ $articles->where('status', 'published')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Draft</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $articles->where('status', 'draft')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Views</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $articles->sum('views') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-eye text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Artikel
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Penulis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Views
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($articles as $article)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if($article->featured_image)
                                        <img src="{{ Storage::url($article->featured_image) }}" alt="Thumbnail" class="w-16 h-16 rounded-lg object-cover mr-4">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-primary-400 to-secondary-400 flex items-center justify-center mr-4">
                                            <i class="fas fa-image text-white text-xl"></i>
                                        </div>
                                    @endif
                                    <div class="max-w-xs">
                                        <div class="text-sm font-medium text-gray-900 flex items-center">
                                            {{ Str::limit($article->title, 40) }}
                                            @if($article->article_type === 'external')
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-external-link-alt mr-1"></i>
                                                    Eksternal
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">{{ Str::limit(strip_tags($article->content), 60) }}</div>
                                        @if($article->article_type === 'external' && $article->source_name)
                                            <p class="text-xs text-blue-600 mt-1">
                                                <i class="fas fa-link mr-1"></i>
                                                Sumber: {{ $article->source_name }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($article->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $article->user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($article->category)
                                    <span class="badge badge-info">{{ $article->category->name }}</span>
                                @else
                                    <span class="badge bg-gray-200 text-gray-600">No Category</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($article->status == 'published')
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-warning">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <i class="fas fa-eye mr-1"></i> {{ number_format($article->views) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $article->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($article->article_type === 'external' && $article->external_url)
                                    <a href="{{ $article->external_url }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-900 mr-3"
                                       title="Buka Sumber">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @else
                                    <a href="{{ route('admin.articles.show', $article) }}"
                                       class="text-primary-600 hover:text-primary-900 mr-3"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif

                                <a href="{{ route('admin.articles.edit', $article) }}"
                                   class="text-green-600 hover:text-green-900 mr-3"
                                   title="Edit Artikel">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.articles.destroy', $article) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('⚠️ Yakin ingin menghapus artikel \'{{ Str::limit($article->title, 50) }}\'?\n\nData tidak dapat dikembalikan!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900"
                                            title="Hapus Artikel">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4 text-gray-300 block"></i>
                                <p class="mb-4">Belum ada artikel</p>
                                <a href="{{ url('/admin/articles/create') }}" class="btn btn-primary inline-block">
                                    <i class="fas fa-plus mr-2"></i>
                                    Buat Artikel Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
