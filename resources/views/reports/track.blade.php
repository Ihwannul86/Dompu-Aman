@extends('layouts.app')

@section('title', 'Lacak Laporan - Dompu Aman')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-20">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Lacak Laporan</h1>
            <p class="text-xl text-white/90">Masukkan nomor laporan untuk melihat status terkini</p>
        </div>
    </div>
</section>

<!-- Track Form -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto">
            <!-- Search Form -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <form action="{{ route('reports.track') }}" method="GET">
                    <div class="mb-6">
                        <label for="report_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Laporan
                        </label>
                        <div class="flex space-x-3">
                            <input type="text"
                                   id="report_number"
                                   name="report_number"
                                   value="{{ request('report_number') }}"
                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-lg font-mono"
                                   placeholder="RPT-XXXXXXXXXXXXX"
                                   required>
                            <button type="submit" class="btn btn-primary px-8">
                                <i class="fas fa-search mr-2"></i>
                                Lacak
                            </button>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            Contoh: RPT-65A1B2C3D4E5F
                        </p>
                    </div>
                </form>
            </div>

            <!-- Result -->
            @if(request('report_number'))
                @if(isset($report))
                    <!-- Report Found -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-white/80 mb-1">Nomor Laporan</p>
                                    <p class="text-2xl font-bold font-mono">{{ $report->report_number }}</p>
                                </div>
                                <div class="text-right">
                                    @if($report->status == 'pending')
                                        <span class="inline-block px-4 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold">
                                            Pending
                                        </span>
                                    @elseif($report->status == 'verified')
                                        <span class="inline-block px-4 py-2 bg-blue-500 text-white rounded-full text-sm font-semibold">
                                            Terverifikasi
                                        </span>
                                    @elseif($report->status == 'in_progress')
                                        <span class="inline-block px-4 py-2 bg-purple-500 text-white rounded-full text-sm font-semibold">
                                            Diproses
                                        </span>
                                    @elseif($report->status == 'resolved')
                                        <span class="inline-block px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">
                                            <i class="fas fa-check mr-1"></i>
                                            Selesai
                                        </span>
                                    @elseif($report->status == 'rejected')
                                        <span class="inline-block px-4 py-2 bg-red-500 text-white rounded-full text-sm font-semibold">
                                            Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Title -->
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $report->title }}</h2>

                            <!-- Info Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-tag text-primary-600 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Kategori</p>
                                        <p class="font-medium text-gray-900">{{ $report->category->name ?? '-' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-map-marker-alt text-primary-600 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Lokasi</p>
                                        <p class="font-medium text-gray-900">{{ $report->location }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-calendar text-primary-600 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Laporan</p>
                                        <p class="font-medium text-gray-900">{{ $report->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-clock text-primary-600 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Terakhir Update</p>
                                        <p class="font-medium text-gray-900">{{ $report->updated_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <h3 class="font-semibold text-gray-900 mb-2">Deskripsi</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $report->description }}</p>
                            </div>

                            <!-- Image -->
                            @if($report->image)
                                <div class="mb-6">
                                    <h3 class="font-semibold text-gray-900 mb-2">Bukti Foto</h3>
                                    <img src="{{ Storage::url($report->image) }}"
                                         alt="Bukti"
                                         class="rounded-lg max-w-full h-auto">
                                </div>
                            @endif

                            <!-- Timeline -->
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="font-semibold text-gray-900 mb-4">Timeline Status</h3>
                                <div class="space-y-4">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-check text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">Laporan Diterima</p>
                                            <p class="text-sm text-gray-500">{{ $report->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>

                                    @if($report->status != 'pending')
                                        <div class="flex items-start space-x-4">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-check text-blue-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900">Terverifikasi</p>
                                                <p class="text-sm text-gray-500">Laporan telah diverifikasi oleh tim</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if(in_array($report->status, ['in_progress', 'resolved']))
                                        <div class="flex items-start space-x-4">
                                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-spinner text-purple-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900">Sedang Diproses</p>
                                                <p class="text-sm text-gray-500">Tim kami sedang menangani laporan Anda</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($report->status == 'resolved')
                                        <div class="flex items-start space-x-4">
                                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-check-circle text-green-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900">Selesai</p>
                                                <p class="text-sm text-gray-500">Laporan telah diselesaikan</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if($report->status == 'rejected')
                                        <div class="flex items-start space-x-4">
                                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-times text-red-600"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900">Ditolak</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $report->rejection_reason ?? 'Laporan tidak memenuhi kriteria' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Report Not Found -->
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Laporan Tidak Ditemukan</h3>
                        <p class="text-gray-600 mb-6">
                            Nomor laporan <span class="font-mono font-semibold">{{ request('report_number') }}</span> tidak ditemukan dalam sistem.
                        </p>
                        <p class="text-sm text-gray-500">
                            Pastikan Anda memasukkan nomor laporan dengan benar.
                        </p>
                    </div>
                @endif
            @else
                <!-- Info Card -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 text-xl mt-1 mr-4"></i>
                        <div>
                            <h3 class="font-semibold text-blue-900 mb-2">Cara Melacak Laporan</h3>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Masukkan nomor laporan yang Anda terima saat membuat laporan</li>
                                <li>• Nomor laporan berbentuk: RPT-XXXXXXXXXXXXX</li>
                                <li>• Anda akan melihat status dan progres penanganan laporan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
