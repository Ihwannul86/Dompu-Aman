@extends('layouts.admin')

@section('title', 'Detail Kategori - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Kategori
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Category Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-lg {{ $category->color ?? 'bg-gray-200' }} flex items-center justify-center text-white text-2xl">
                            <i class="fas {{ $category->icon ?? 'fa-tag' }}"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
                        @if($category->type == 'report')
                            <span class="badge bg-orange-100 text-orange-800 mt-2">
                                <i class="fas fa-flag mr-1"></i>
                                Kategori Laporan
                            </span>
                        @else
                            <span class="badge bg-green-100 text-green-800 mt-2">
                                <i class="fas fa-newspaper mr-1"></i>
                                Kategori Artikel
                            </span>
                        @endif
                    </div>
                </div>

                @if($category->description)
                    <div class="mt-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Deskripsi:</h3>
                        <p class="text-gray-700">{{ $category->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Statistik Penggunaan</h3>

                <div class="grid grid-cols-2 gap-4">
                    @if($category->type == 'report')
                        <div class="text-center p-6 bg-orange-50 rounded-lg">
                            <p class="text-4xl font-bold text-orange-600">{{ $category->reports_count ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-2">Total Laporan</p>
                        </div>
                        <div class="text-center p-6 bg-blue-50 rounded-lg">
                            <p class="text-4xl font-bold text-blue-600">0</p>
                            <p class="text-sm text-gray-600 mt-2">Pending</p>
                        </div>
                    @else
                        <div class="text-center p-6 bg-green-50 rounded-lg">
                            <p class="text-4xl font-bold text-green-600">{{ $category->articles_count ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-2">Total Artikel</p>
                        </div>
                        <div class="text-center p-6 bg-purple-50 rounded-lg">
                            <p class="text-4xl font-bold text-purple-600">0</p>
                            <p class="text-sm text-gray-600 mt-2">Published</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Category Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Detail Kategori</h3>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">ID</p>
                        <p class="font-mono text-sm">{{ $category->id }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Slug</p>
                        <p class="font-mono text-sm">{{ $category->slug }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Icon</p>
                        <p class="font-mono text-sm">{{ $category->icon ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Warna</p>
                        <div class="flex items-center space-x-2 mt-1">
                            <div class="w-6 h-6 rounded {{ $category->color ?? 'bg-gray-200' }}"></div>
                            <span class="font-mono text-sm">{{ $category->color ?? '-' }}</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Dibuat pada</p>
                        <p class="text-gray-900">{{ $category->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Terakhir diupdate</p>
                        <p class="text-gray-900">{{ $category->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Aksi</h3>

                <div class="space-y-2">
                    <button class="w-full btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Kategori
                    </button>

                    <button class="w-full btn bg-red-600 hover:bg-red-700 text-white">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Kategori
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
