@extends('layouts.app')

@section('title', 'Tentang Kami - Dompu Aman')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-20">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang Dompu Aman</h1>
            <p class="text-xl text-white/90">Platform pelaporan dan edukasi keamanan untuk masyarakat Dompu</p>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 max-w-6xl mx-auto">
            <!-- Vision -->
            <div class="text-center p-8">
                <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-eye text-primary-600 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Visi</h2>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi platform terdepan dalam menciptakan lingkungan yang aman dan nyaman bagi seluruh masyarakat Kabupaten Dompu melalui kolaborasi dan transparansi.
                </p>
            </div>

            <!-- Mission -->
            <div class="text-center p-8">
                <div class="w-20 h-20 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-bullseye text-secondary-600 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Misi</h2>
                <p class="text-gray-600 leading-relaxed">
                    Memfasilitasi masyarakat untuk melaporkan kejadian, menyediakan edukasi keamanan, dan membangun komunikasi yang efektif antara masyarakat dengan aparat.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
            <p class="text-gray-600 text-lg">Layanan yang kami sediakan untuk masyarakat Dompu</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Feature 1 -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-flag text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pelaporan</h3>
                <p class="text-gray-600">
                    Laporkan kejadian atau masalah keamanan dengan mudah dan cepat melalui platform digital
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-newspaper text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Artikel Edukasi</h3>
                <p class="text-gray-600">
                    Akses informasi dan tips keamanan untuk meningkatkan kewaspadaan masyarakat
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center hover:shadow-md transition-shadow">
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-comments text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Forum Diskusi</h3>
                <p class="text-gray-600">
                    Berdiskusi dan berbagi pengalaman dengan komunitas untuk solusi bersama
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team/Stats - UPDATED -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Dampak Kami</h2>
            <p class="text-gray-600 text-lg">Bersama membangun Dompu yang lebih aman</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
            <div class="text-center">
                <div class="text-4xl font-bold text-primary-600 mb-2">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="text-gray-600">Pengguna Aktif</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-orange-600 mb-2">{{ $stats['total_reports'] ?? 0 }}</div>
                <div class="text-gray-600">Laporan Masuk</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-green-600 mb-2">{{ $stats['total_articles'] ?? 0 }}</div>
                <div class="text-gray-600">Artikel Edukasi</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-purple-600 mb-2">{{ $stats['total_forums'] ?? 0 }}</div>
                <div class="text-gray-600">Diskusi Forum</div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-16">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Berkontribusi?</h2>
        <p class="text-xl text-white/90 mb-8">Bergabunglah dengan kami dalam menciptakan Dompu yang lebih aman</p>
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4">
            @guest
                <a href="{{ route('register') }}" class="btn bg-white text-primary-600 hover:bg-gray-100">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </a>
            @else
                <a href="{{ route('reports.create') }}" class="btn bg-white text-primary-600 hover:bg-gray-100">
                    <i class="fas fa-flag mr-2"></i>
                    Buat Laporan
                </a>
            @endguest
            <a href="{{ route('contact') }}" class="btn bg-white/20 text-white border border-white hover:bg-white/30">
                <i class="fas fa-envelope mr-2"></i>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
