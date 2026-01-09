@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-2">Selamat datang kembali, Admin Dompu Aman!</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Pengguna</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</p>
                        <p class="text-green-600 text-sm mt-2">
                            <i class="fas fa-user-check mr-1"></i>
                            {{ $activeUsers }} aktif
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Articles -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Artikel</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalArticles }}</p>
                        <p class="text-green-600 text-sm mt-2">
                            <i class="fas fa-check-circle mr-1"></i>
                            {{ $publishedArticles }} published
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-newspaper text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Reports -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Laporan</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalReports }}</p>
                        <p class="text-orange-600 text-sm mt-2">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $reportStats['pending'] }} pending
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-flag text-orange-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Forums -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Forum</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalForums }}</p>
                        <p class="text-purple-600 text-sm mt-2">
                            <i class="fas fa-comments mr-1"></i>
                            {{ $activeForums }} aktif
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-comments text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Report Status Chart -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Status Laporan</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Pending</span>
                        <span class="font-semibold text-orange-600">{{ $reportStats['pending'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $totalReports > 0 ? ($reportStats['pending'] / $totalReports * 100) : 0 }}%"></div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Terverifikasi</span>
                        <span class="font-semibold text-blue-600">{{ $reportStats['verified'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $totalReports > 0 ? ($reportStats['verified'] / $totalReports * 100) : 0 }}%"></div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Diproses</span>
                        <span class="font-semibold text-purple-600">{{ $reportStats['in_progress'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $totalReports > 0 ? ($reportStats['in_progress'] / $totalReports * 100) : 0 }}%"></div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Selesai</span>
                        <span class="font-semibold text-green-600">{{ $reportStats['resolved'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalReports > 0 ? ($reportStats['resolved'] / $totalReports * 100) : 0 }}%"></div>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Ditolak</span>
                        <span class="font-semibold text-red-600">{{ $reportStats['rejected'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalReports > 0 ? ($reportStats['rejected'] / $totalReports * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.reports.index') }}" class="p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors text-center">
                        <i class="fas fa-flag text-blue-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">Kelola Laporan</p>
                    </a>
                    <a href="{{ route('admin.articles.index') }}" class="p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors text-center">
                        <i class="fas fa-newspaper text-green-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">Kelola Artikel</p>
                    </a>
                    <a href="{{ route('admin.forums.index') }}" class="p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors text-center">
                        <i class="fas fa-comments text-purple-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">Kelola Forum</p>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors text-center">
                        <i class="fas fa-users text-orange-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">Kelola Pengguna</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">Laporan Terbaru</h2>
                <a href="{{ route('admin.reports.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentReports->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Laporan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelapor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentReports as $report)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-mono text-gray-900">{{ $report->report_number }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($report->title, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $report->user->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600">{{ $report->category->name ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($report->status == 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Pending</span>
                                        @elseif($report->status == 'verified')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Terverifikasi</span>
                                        @elseif($report->status == 'in_progress')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Diproses</span>
                                        @elseif($report->status == 'resolved')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $report->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500">Belum ada laporan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
