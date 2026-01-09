@extends('layouts.admin')

@section('title', 'Kelola Forum - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Forum</h1>
            <p class="text-gray-600 mt-1">Kelola diskusi dan topik forum dari masyarakat</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">
                <i class="fas fa-filter mr-2"></i>
                Filter
            </button>
            <button class="btn btn-primary">
                <i class="fas fa-download mr-2"></i>
                Export
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Forum</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $forums->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comments text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Aktif</p>
                    <p class="text-2xl font-bold text-green-600">{{ $forums->where('status', 'active')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Terkunci</p>
                    <p class="text-2xl font-bold text-red-600">{{ $forums->where('status', 'locked')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lock text-red-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Komentar</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $forums->sum('comments_count') }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comment-dots text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Forums Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Topik
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pembuat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Komentar
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Views
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
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
                    @forelse($forums as $forum)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($forum->title, 50) }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit(strip_tags($forum->content), 80) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($forum->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $forum->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $forum->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-comment mr-1"></i>
                                    {{ $forum->comments_count ?? 0 }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <i class="fas fa-eye mr-1"></i> {{ number_format($forum->views ?? 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($forum->status == 'active')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($forum->status == 'locked')
                                    <span class="badge badge-danger">Terkunci</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $forum->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.forums.show', $forum) }}" class="text-primary-600 hover:text-primary-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($forum->status == 'active')
                                    <button class="text-red-600 hover:text-red-900 mr-3">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                @else
                                    <button class="text-green-600 hover:text-green-900 mr-3">
                                        <i class="fas fa-unlock"></i>
                                    </button>
                                @endif
                                <button class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                <p>Belum ada forum diskusi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($forums->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $forums->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
