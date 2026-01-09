@extends('layouts.app')

@section('title', 'Laporan Masyarakat - Dompu Aman')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-20">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Laporan Masyarakat</h1>
                <p class="text-xl text-white/90">Lihat dan lacak laporan dari masyarakat Dompu</p>
            </div>
            @auth
                <a href="{{ route('reports.create') }}" class="btn bg-white text-primary-600 hover:bg-gray-100">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Laporan
                </a>
            @endauth
        </div>
    </div>
</section>

<!-- Reports Grid -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        @if($reports->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($reports as $report)
                    <article class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        <!-- Image -->
                        @if($report->image)
                            <img src="{{ Storage::url($report->image) }}"
                                 alt="{{ $report->title }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center">
                                <i class="fas fa-flag text-white text-4xl"></i>
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Status Badge -->
                            @if($report->status == 'pending')
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-orange-700 bg-orange-100 rounded-full mb-3">
                                    Pending
                                </span>
                            @elseif($report->status == 'verified')
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full mb-3">
                                    Terverifikasi
                                </span>
                            @elseif($report->status == 'in_progress')
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-purple-700 bg-purple-100 rounded-full mb-3">
                                    Diproses
                                </span>
                            @elseif($report->status == 'resolved')
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full mb-3">
                                    Selesai
                                </span>
                            @endif

                            <!-- Category -->
                            @if($report->category)
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-primary-700 bg-primary-100 rounded-full mb-3 ml-2">
                                    {{ $report->category->name }}
                                </span>
                            @endif

                            <!-- Title -->
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                {{ Str::limit($report->title, 60) }}
                            </h3>

                            <!-- Description -->
                            <p class="text-gray-600 mb-3 text-sm line-clamp-2">
                                {{ Str::limit($report->description, 100) }}
                            </p>

                            <!-- Location -->
                            <p class="text-sm text-gray-500 mb-3">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ Str::limit($report->location, 50) }}
                            </p>

                            <!-- Meta -->
                            <div class="flex items-center justify-between text-xs text-gray-500 pt-3 border-t border-gray-100">
                                <span>{{ $report->created_at->diffForHumans() }}</span>
                                <span class="font-mono">{{ $report->report_number }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $reports->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <i class="fas fa-inbox text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">Belum Ada Laporan</h3>
                <p class="text-gray-600 mb-6">Jadilah yang pertama melaporkan kejadian!</p>
                @auth
                    <a href="{{ route('reports.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Laporan
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login untuk Melapor
                    </a>
                @endauth
            </div>
        @endif
    </div>
</section>
@endsection
