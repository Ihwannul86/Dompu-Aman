@extends('layouts.admin')

@section('title', 'Detail Pengguna - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Pengguna
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- User Profile -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center space-x-6 mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-bold text-3xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $user->name }}</h2>
                        <p class="text-gray-600 mb-3">{{ $user->email }}</p>
                        <div class="flex items-center space-x-3">
                            @if($user->role == 'admin')
                                <span class="badge bg-purple-100 text-purple-800">
                                    <i class="fas fa-user-shield mr-1"></i>
                                    Admin
                                </span>
                            @elseif($user->role == 'moderator')
                                <span class="badge bg-green-100 text-green-800">
                                    <i class="fas fa-user-tie mr-1"></i>
                                    Moderator
                                </span>
                            @else
                                <span class="badge bg-blue-100 text-blue-800">
                                    <i class="fas fa-user mr-1"></i>
                                    User
                                </span>
                            @endif

                            @if($user->status == 'active')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Telepon</p>
                        <p class="text-gray-900">{{ $user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Bergabung</p>
                        <p class="text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Activity Statistics -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Statistik Aktivitas</h3>

                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-3xl font-bold text-blue-600">{{ $user->reports_count ?? 0 }}</p>
                        <p class="text-sm text-gray-600 mt-1">Laporan</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-3xl font-bold text-green-600">{{ $user->forums_count ?? 0 }}</p>
                        <p class="text-sm text-gray-600 mt-1">Forum</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <p class="text-3xl font-bold text-purple-600">{{ $user->articles_count ?? 0 }}</p>
                        <p class="text-sm text-gray-600 mt-1">Artikel</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Aktivitas Terakhir</h3>

                <div class="space-y-4">
                    @if($user->reports->count() > 0)
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Laporan Terbaru</h4>
                            @foreach($user->reports->take(3) as $report)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($report->title, 40) }}</p>
                                        <p class="text-xs text-gray-500">{{ $report->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="badge badge-info">{{ $report->category->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($user->forums->count() > 0)
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Forum Terbaru</h4>
                            @foreach($user->forums->take(3) as $forum)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ Str::limit($forum->title, 40) }}</p>
                                        <p class="text-xs text-gray-500">{{ $forum->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="badge badge-success">{{ $forum->comments_count ?? 0 }} komentar</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Account Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Informasi Akun</h3>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">User ID</p>
                        <p class="font-mono text-sm">{{ $user->id }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Email Verified</p>
                        @if($user->email_verified_at)
                            <p class="text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                Terverifikasi
                            </p>
                        @else
                            <p class="text-red-600">
                                <i class="fas fa-times-circle mr-1"></i>
                                Belum Terverifikasi
                            </p>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Terakhir Update</p>
                        <p class="text-gray-900">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($user->id != auth()->id())
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Aksi</h3>

                    <div class="space-y-2">
                        <button class="w-full btn btn-primary">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Pengguna
                        </button>

                        @if($user->status == 'active')
                            <button class="w-full btn btn-warning">
                                <i class="fas fa-ban mr-2"></i>
                                Non-aktifkan
                            </button>
                        @else
                            <button class="w-full btn btn-success">
                                <i class="fas fa-check-circle mr-2"></i>
                                Aktifkan
                            </button>
                        @endif

                        <button class="w-full btn bg-red-600 hover:bg-red-700 text-white">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Pengguna
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
