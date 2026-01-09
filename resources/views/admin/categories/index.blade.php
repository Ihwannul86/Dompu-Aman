@extends('layouts.admin')

@section('title', 'Kelola Kategori - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Kategori</h1>
            <p class="text-gray-600 mt-1">Kelola kategori laporan dan artikel</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">
                <i class="fas fa-filter mr-2"></i>
                Filter
            </button>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Kategori</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $categories->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tags text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Kategori Laporan</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $categories->where('type', 'report')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-flag text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Kategori Artikel</p>
                    <p class="text-2xl font-bold text-green-600">{{ $categories->where('type', 'article')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-newspaper text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Penggunaan</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $categories->sum('reports_count') + $categories->sum('articles_count') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipe
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Slug
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Digunakan
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
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-lg {{ $category->color ?? 'bg-gray-200' }} flex items-center justify-center text-white">
                                            <i class="fas {{ $category->icon ?? 'fa-tag' }}"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                        @if($category->description)
                                            <div class="text-sm text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($category->type == 'report')
                                    <span class="badge bg-orange-100 text-orange-800">
                                        <i class="fas fa-flag mr-1"></i>
                                        Laporan
                                    </span>
                                @else
                                    <span class="badge bg-green-100 text-green-800">
                                        <i class="fas fa-newspaper mr-1"></i>
                                        Artikel
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-xs text-gray-600">{{ $category->slug }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">
                                    @if($category->type == 'report')
                                        <span class="text-gray-900 font-medium">{{ $category->reports_count ?? 0 }}</span>
                                        <span class="text-gray-500"> laporan</span>
                                    @else
                                        <span class="text-gray-900 font-medium">{{ $category->articles_count ?? 0 }}</span>
                                        <span class="text-gray-500"> artikel</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $category->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.categories.show', $category) }}" class="text-primary-600 hover:text-primary-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                <p>Belum ada kategori</p>
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-4">
                                    <i class="fas fa-plus mr-2"></i>
                                    Buat Kategori Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
