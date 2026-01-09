@extends('layouts.admin')

@section('title', 'Kelola Laporan - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Laporan</h1>
            <p class="text-gray-600 mt-1">Kelola dan verifikasi laporan dari masyarakat</p>
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
                    <p class="text-sm text-gray-500 mb-1">Total Laporan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reports->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-flag text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pending</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $reports->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Terverifikasi</p>
                    <p class="text-2xl font-bold text-green-600">{{ $reports->where('status', 'verified')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Selesai</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $reports->where('status', 'resolved')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-double text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nomor Laporan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judul
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pelapor
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
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
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-gray-900">{{ $report->report_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($report->title, 40) }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($report->description, 60) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($report->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $report->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $report->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="badge badge-info">{{ $report->category->name }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $report->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.reports.show', $report) }}" class="text-primary-600 hover:text-primary-900 mr-3">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                <p>Belum ada laporan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
