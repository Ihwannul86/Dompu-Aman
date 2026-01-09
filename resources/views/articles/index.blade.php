@extends('layouts.app')

@section('title', 'Artikel Edukasi - Dompu Aman')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-20">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Artikel Edukasi</h1>
            <p class="text-xl text-white/90">Baca artikel edukatif seputar keamanan dan keselamatan di Dompu</p>
        </div>
    </div>
</section>

<!-- Search & Filter -->
<section class="bg-white border-b border-gray-200 py-6">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Search -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text"
                           placeholder="Cari artikel..."
                           class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Filter by Category -->
            <div class="flex items-center space-x-3">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Articles Grid -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        @if($articles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                    <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        <!-- Thumbnail -->
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}"
                                 alt="{{ $article->title }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center">
                                <i class="fas fa-newspaper text-white text-4xl"></i>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Category Badge -->
                            @if($article->category)
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-primary-700 bg-primary-100 rounded-full mb-3">
                                    {{ $article->category->name }}
                                </span>
                            @endif

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-primary-600 transition-colors">
                                <a href="{{ route('articles.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>

                            <!-- Excerpt -->
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($article->content), 120) }}
                            </p>

                            <!-- Meta -->
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold text-xs">
                                        {{ strtoupper(substr($article->author->name, 0, 1)) }}
                                    </div>
                                    <span>{{ $article->author->name }}</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span><i class="fas fa-eye mr-1"></i>{{ number_format($article->views) }}</span>
                                    <span>{{ $article->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <i class="fas fa-newspaper text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">Belum Ada Artikel</h3>
                <p class="text-gray-600">Artikel edukasi akan ditampilkan di sini.</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-16">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-4">Punya Pertanyaan?</h2>
        <p class="text-xl text-white/90 mb-8">Gabung diskusi di forum komunitas kami</p>
        <a href="{{ route('forums.index') }}" class="btn bg-white text-primary-600 hover:bg-gray-100">
            <i class="fas fa-comments mr-2"></i>
            Forum Diskusi
        </a>
    </div>
</section>
@endsection
