@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Pengguna</h1>
            <p class="text-gray-600 mt-1">Kelola akun pengguna dan administrator</p>
        </div>
        <div class="flex space-x-3">
            <button class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">
                <i class="fas fa-filter mr-2"></i>
                Filter
            </button>
            <button class="btn btn-primary">
                <i class="fas fa-user-plus mr-2"></i>
                Tambah Admin
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $users->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Admin</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $users->where('role', 'admin')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-shield text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Moderator</p>
                    <p class="text-2xl font-bold text-green-600">{{ $users->where('role', 'moderator')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-tie text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pengguna Biasa</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $users->where('role', 'user')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pengguna
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Telepon
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Terdaftar
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-bold text-lg">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->status == 'active')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($user->status == 'inactive')
                                    <span class="badge badge-warning">Tidak Aktif</span>
                                @else
                                    <span class="badge badge-danger">Banned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-primary-600 hover:text-primary-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($user->id != auth()->id())
                                    @if($user->status == 'active')
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @else
                                        <button class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                <p>Belum ada pengguna</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
