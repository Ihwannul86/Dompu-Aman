@extends('layouts.app')

@section('title', 'Beranda - Dompu Aman')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-500 via-secondary-500 to-primary-600 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-lg rounded-full mb-4">
                    <i class="fas fa-shield-alt text-4xl"></i>
                </div>
            </div>
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                Selamat Datang di Dompu Aman
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-white/90">
                Platform Edukasi & Pelaporan Sosial untuk Masyarakat Kabupaten Dompu
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('reports.create') }}" class="btn btn-lg bg-white text-primary-600 hover:bg-gray-100">
                    <i class="fas fa-flag mr-2"></i>
                    Buat Laporan
                </a>
                <a href="{{ route('articles.index') }}" class="btn btn-lg bg-white/10 backdrop-blur-lg text-white hover:bg-white/20 border-2 border-white">
                    <i class="fas fa-book-reader mr-2"></i>
                    Baca Artikel
                </a>
            </div>
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
            <p class="text-lg text-gray-600">Platform lengkap untuk meningkatkan kesadaran masyarakat</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="card p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 text-blue-600 rounded-full mb-6">
                    <i class="fas fa-flag text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pelaporan Sosial</h3>
                <p class="text-gray-600">Laporkan masalah sosial di sekitar Anda dengan mudah dan aman</p>
            </div>

            <!-- Feature 2 -->
            <div class="card p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 text-green-600 rounded-full mb-6">
                    <i class="fas fa-book-reader text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Artikel Edukasi</h3>
                <p class="text-gray-600">Baca artikel edukatif tentang berbagai isu sosial dan keamanan</p>
            </div>

            <!-- Feature 3 -->
            <div class="card p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 text-purple-600 rounded-full mb-6">
                    <i class="fas fa-comments text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Forum Diskusi</h3>
                <p class="text-gray-600">Diskusikan berbagai topik dengan komunitas Dompu</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="text-gray-600">Pengguna Aktif</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-green-600 mb-2">{{ $stats['total_articles'] ?? 0 }}</div>
                <div class="text-gray-600">Artikel Edukasi</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-purple-600 mb-2">{{ $stats['total_forums'] ?? 0 }}</div>
                <div class="text-gray-600">Diskusi Forum</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-orange-600 mb-2">{{ $stats['total_reports'] ?? 0 }}</div>
                <div class="text-gray-600">Laporan Masuk</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-primary-600 to-secondary-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Bergabunglah dengan Komunitas Dompu Aman</h2>
        <p class="text-xl mb-8 text-white/90">Mari bersama-sama membangun Kabupaten Dompu yang lebih aman dan sejahtera</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-lg bg-white text-primary-600 hover:bg-gray-100">
                <i class="fas fa-user-plus mr-2"></i>
                Daftar Sekarang
            </a>
        @endguest
        @auth
            <a href="{{ route('reports.create') }}" class="btn btn-lg bg-white text-primary-600 hover:bg-gray-100">
                <i class="fas fa-flag mr-2"></i>
                Buat Laporan Baru
            </a>
        @endauth
    </div>
</section>
@endsection
