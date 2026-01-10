@extends('layouts.app')

@section('title', $article->title . ' - Dompu Aman')

@section('content')
<!-- Article Header -->
<article class="py-12">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="text-sm text-gray-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-primary-600">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('articles.index') }}" class="hover:text-primary-600">Artikel</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ Str::limit($article->title, 50) }}</span>
            </nav>

            <!-- Category Badge -->
            @if($article->category)
                <span class="inline-block px-4 py-2 text-sm font-semibold text-primary-700 bg-primary-100 rounded-full mb-4">
                    {{ $article->category->name }}
                </span>
            @endif

            <!-- External Article Badge -->
            @if($article->article_type === 'external')
                <span class="inline-block px-4 py-2 text-sm font-semibold text-blue-700 bg-blue-100 rounded-full mb-4 ml-2">
                    <i class="fas fa-external-link-alt mr-1"></i>
                    Artikel Eksternal
                </span>
            @endif

            <!-- Title -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                {{ $article->title }}
            </h1>

            <!-- Meta -->
            <div class="flex items-center justify-between py-4 border-y border-gray-200 mb-8">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($article->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $article->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $article->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 text-gray-500">
                    <span><i class="fas fa-eye mr-2"></i>{{ number_format($article->views) }}</span>
                    <span><i class="fas fa-clock mr-2"></i>{{ $article->created_at->diffForHumans() }}</span>
                </div>
            </div>

            <!-- External Source Info -->
            @if($article->article_type === 'external' && $article->external_url)
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded-r-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 text-2xl mt-1 mr-4"></i>
                        <div class="flex-1">
                            <p class="text-base text-blue-900 font-semibold mb-2">📰 Artikel dari Sumber Eksternal</p>
                            <p class="text-sm text-blue-800 mb-3">
                                Artikel ini dikurasi dari sumber terpercaya
                                @if($article->source_name)
                                    : <strong class="font-bold">{{ $article->source_name }}</strong>
                                @endif
                            </p>
                            <a href="{{ $article->external_url }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Baca artikel lengkap di sumber asli
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Thumbnail -->
            @if($article->featured_image)
                <img src="{{ Storage::url($article->featured_image) }}"
                     alt="{{ $article->title }}"
                     class="w-full h-auto rounded-lg shadow-md mb-8">
            @endif

            <!-- Excerpt -->
            @if($article->excerpt)
                <div class="bg-gray-50 border-l-4 border-gray-400 p-6 mb-8 rounded-r-lg">
                    <p class="text-lg text-gray-700 italic">{{ $article->excerpt }}</p>
                </div>
            @endif

            <!-- Content -->
            <div class="prose prose-lg max-w-none mb-8">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Source Credit for External -->
            @if($article->article_type === 'external' && $article->source_name)
                <div class="bg-gray-100 p-4 rounded-lg mb-8">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-copyright mr-2"></i>
                        Artikel ini bersumber dari <strong>{{ $article->source_name }}</strong>.
                        Semua hak cipta dan konten adalah milik penulis dan penerbit asli.
                    </p>
                </div>
            @endif

            <!-- Share Buttons -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Artikel:</h3>
                <div class="flex items-center space-x-3">
                    <button class="btn bg-blue-600 hover:bg-blue-700 text-white">
                        <i class="fab fa-facebook-f mr-2"></i>
                        Facebook
                    </button>
                    <button class="btn bg-blue-400 hover:bg-blue-500 text-white">
                        <i class="fab fa-twitter mr-2"></i>
                        Twitter
                    </button>
                    <button class="btn bg-green-500 hover:bg-green-600 text-white">
                        <i class="fab fa-whatsapp mr-2"></i>
                        WhatsApp
                    </button>
                </div>
            </div>

            <!-- Related Articles -->
            @if(isset($relatedArticles) && $relatedArticles->count() > 0)
                <div class="mt-16">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Artikel Terkait</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('articles.show', $related->slug) }}"
                               class="block bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                                @if($related->featured_image)
                                    <img src="{{ Storage::url($related->featured_image) }}"
                                         alt="{{ $related->title }}"
                                         class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center">
                                        <i class="fas fa-newspaper text-white text-3xl"></i>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">{{ Str::limit($related->title, 60) }}</h4>
                                    <p class="text-sm text-gray-500">{{ $related->created_at->format('d M Y') }}</p>
                                    @if($related->article_type === 'external')
                                        <span class="inline-block mt-2 px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            Eksternal
                                        </span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</article>
@endsection
