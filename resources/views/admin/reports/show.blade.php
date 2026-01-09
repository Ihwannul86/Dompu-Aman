@extends('layouts.admin')

@section('title', 'Detail Laporan - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.reports.index') }}" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Laporan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Report Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $report->title }}</h2>
                    @if($report->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($report->status == 'verified')
                        <span class="badge badge-info">Terverifikasi</span>
                    @elseif($report->status == 'in_progress')
                        <span class="badge badge-primary">Diproses</span>
                    @elseif($report->status == 'resolved')
                        <span class="badge badge-success">Selesai</span>
                    @else
                        <span class="badge badge-danger">Ditolak</span>
                    @endif
                </div>

                <div class="prose max-w-none">
                    <p class="text-gray-700">{{ $report->description }}</p>
                </div>

                @if($report->location)
                    <div class="mt-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Lokasi:</h3>
                        <p class="text-gray-700"><i class="fas fa-map-marker-alt mr-2"></i>{{ $report->location }}</p>
                    </div>
                @endif

                @if($report->image)
                    <div class="mt-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Bukti Foto:</h3>
                        <img src="{{ Storage::url($report->image) }}" alt="Report Image" class="rounded-lg max-w-full h-auto">
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Report Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Detail Laporan</h3>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Nomor Laporan</p>
                        <p class="font-mono font-semibold">{{ $report->report_number }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <span class="badge badge-info mt-1">{{ $report->category->name }}</span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Dilaporkan pada</p>
                        <p class="text-gray-900">{{ $report->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Reporter Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Pelapor</h3>

                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold text-lg">
                        {{ strtoupper(substr($report->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">{{ $report->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $report->user->email }}</p>
                    </div>
                </div>

                @if($report->user->phone)
                    <div class="mt-3">
                        <p class="text-sm text-gray-500">Telepon</p>
                        <p class="text-gray-900">{{ $report->user->phone }}</p>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Aksi</h3>

                <div class="space-y-2">
                    @if($report->status == 'pending')
                        <button class="w-full btn btn-success">
                            <i class="fas fa-check mr-2"></i>
                            Verifikasi
                        </button>
                        <button class="w-full btn btn-danger">
                            <i class="fas fa-times mr-2"></i>
                            Tolak
                        </button>
                    @elseif($report->status == 'verified')
                        <button class="w-full btn btn-primary">
                            <i class="fas fa-cog mr-2"></i>
                            Proses
                        </button>
                    @elseif($report->status == 'in_progress')
                        <button class="w-full btn btn-success">
                            <i class="fas fa-check-double mr-2"></i>
                            Selesaikan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
