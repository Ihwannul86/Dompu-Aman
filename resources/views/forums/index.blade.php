@extends('layouts.app')

@section('title', 'Forum Diskusi - Dompu Aman')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-20">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Forum Diskusi</h1>
                <p class="text-xl text-white/90">Diskusikan isu keamanan dan keselamatan bersama komunitas</p>
            </div>
            @auth
                <a href="{{ route('forums.create') }}" class="btn bg-white text-primary-600 hover:bg-gray-100">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Diskusi
                </a>
            @endauth
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
                           placeholder="Cari topik diskusi..."
                           class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Sort -->
            <div class="flex items-center space-x-3">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="latest">Terbaru</option>
                    <option value="popular">Terpopuler</option>
                    <option value="most-commented">Banyak Komentar</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Forums List -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        @if($forums->count() > 0)
            <div class="space-y-4">
                @foreach($forums as $forum)
                    <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
                        <div class="flex items-start space-x-4">
                            <!-- User Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($forum->user->name, 0, 1)) }}
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-primary-600 transition-colors">
                                    <a href="{{ route('forums.show', $forum->slug) }}">
                                        {{ $forum->title }}
                                    </a>
                                </h3>

                                <!-- Excerpt -->
                                <p class="text-gray-600 mb-4 line-clamp-2">
                                    {{ Str::limit(strip_tags($forum->content), 200) }}
                                </p>

                                <!-- Meta -->
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center space-x-4">
                                        <span class="font-medium text-gray-900">{{ $forum->user->name }}</span>
                                        <span>{{ $forum->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span>
                                            <i class="fas fa-comment mr-1"></i>
                                            {{ $forum->comments_count }} komentar
                                        </span>
                                        <span>
                                            <i class="fas fa-eye mr-1"></i>
                                            {{ number_format($forum->views ?? 0) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $forums->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <i class="fas fa-comments text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">Belum Ada Diskusi</h3>
                <p class="text-gray-600 mb-6">Jadilah yang pertama memulai diskusi!</p>
                @auth
                    <a href="{{ route('forums.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Diskusi Baru
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login untuk Berdiskusi
                    </a>
                @endauth
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
@guest
    <section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">Bergabunglah dengan Komunitas</h2>
            <p class="text-xl text-white/90 mb-8">Daftar sekarang untuk ikut berdiskusi dan berbagi informasi</p>
            <a href="{{ route('register') }}" class="btn bg-white text-primary-600 hover:bg-gray-100">
                <i class="fas fa-user-plus mr-2"></i>
                Daftar Sekarang
            </a>
        </div>
    </section>
@endguest
@endsection
