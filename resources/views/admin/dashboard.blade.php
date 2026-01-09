@extends('layouts.admin')

@section('title', 'Dashboard Admin - Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600 mt-2">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_users'] }}</p>
                    <p class="text-green-600 text-sm mt-2">
                        <i class="fas fa-user-check mr-1"></i>
                        {{ $stats['active_users'] }} aktif
                    </p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Articles -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Artikel</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_articles'] }}</p>
                    <p class="text-green-600 text-sm mt-2">
                        <i class="fas fa-check-circle mr-1"></i>
                        {{ $stats['published_articles'] }} published
                    </p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-newspaper text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Forums -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Forum</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_forums'] }}</p>
                    <p class="text-blue-600 text-sm mt-2">
                        <i class="fas fa-comments mr-1"></i>
                        Diskusi aktif
                    </p>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <i class="fas fa-comments text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Reports -->
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Laporan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_reports'] }}</p>
                    <p class="text-orange-600 text-sm mt-2">
                        <i class="fas fa-clock mr-1"></i>
                        {{ $stats['pending_reports'] }} pending
                    </p>
                </div>
                <div class="bg-orange-100 p-4 rounded-full">
                    <i class="fas fa-flag text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Reports -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Laporan Terbaru</h2>
                <a href="{{ route('admin.reports.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentReports->count() > 0)
                <div class="space-y-3">
                    @foreach($recentReports as $report)
                        <div class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="flex-shrink-0">
                                <span class="badge @if($report->status == 'pending') badge-warning @elseif($report->status == 'verified') badge-success @else badge-danger @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $report->title }}</p>
                                <p class="text-xs text-gray-500">{{ $report->user->name }} • {{ $report->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada laporan</p>
            @endif
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Pengguna Terbaru</h2>
                <a href="{{ route('admin.users.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentUsers->count() > 0)
                <div class="space-y-3">
                    @foreach($recentUsers as $user)
                        <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                            <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada pengguna</p>
            @endif
        </div>
    </div>
</div>
@endsection
