@extends('layouts.admin')

@section('title', 'Detail Laporan - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

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
                    <h2 class="text-2xl font-bold text-gray-900">Detail Laporan</h2>
                    @if($report->status == 'pending')
                        <span class="inline-block px-4 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold">
                            Pending
                        </span>
                    @elseif($report->status == 'reviewing')
                        <span class="inline-block px-4 py-2 bg-blue-500 text-white rounded-full text-sm font-semibold">
                            Sedang Ditinjau
                        </span>
                    @elseif($report->status == 'investigating')
                        <span class="inline-block px-4 py-2 bg-purple-500 text-white rounded-full text-sm font-semibold">
                            Sedang Diselidiki
                        </span>
                    @elseif($report->status == 'resolved')
                        <span class="inline-block px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">
                            <i class="fas fa-check mr-1"></i>Selesai
                        </span>
                    @elseif($report->status == 'rejected')
                        <span class="inline-block px-4 py-2 bg-red-500 text-white rounded-full text-sm font-semibold">
                            Ditolak
                        </span>
                    @else
                        <span class="inline-block px-4 py-2 bg-gray-500 text-white rounded-full text-sm font-semibold">
                            {{ ucfirst($report->status) }}
                        </span>
                    @endif
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-200">
                    <div>
                        <p class="text-sm text-gray-500">Jenis Insiden</p>
                        <p class="font-medium capitalize text-gray-900">{{ $report->incident_type ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Prioritas</p>
                        <p class="font-medium capitalize">
                            @if($report->priority == 'low')
                                <span class="text-green-600">● Rendah</span>
                            @elseif($report->priority == 'medium')
                                <span class="text-blue-600">● Sedang</span>
                            @elseif($report->priority == 'high')
                                <span class="text-orange-600">● Tinggi</span>
                            @elseif($report->priority == 'urgent')
                                <span class="text-red-600">● Mendesak</span>
                            @else
                                <span class="text-gray-600">-</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tingkat Keparahan</p>
                        <p class="font-medium capitalize text-gray-900">
                            @if($report->severity == 'minor')
                                Ringan
                            @elseif($report->severity == 'moderate')
                                Sedang
                            @elseif($report->severity == 'serious')
                                Serius
                            @elseif($report->severity == 'critical')
                                Kritis
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Kejadian</p>
                        <p class="font-medium text-gray-900">
                            @if($report->incident_date)
                                {{ \Carbon\Carbon::parse($report->incident_date)->format('d M Y') }}
                                @if($report->incident_time)
                                    , {{ \Carbon\Carbon::parse($report->incident_time)->format('H:i') }}
                                @endif
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">Deskripsi:</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $report->incident_description ?? $report->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>

                <!-- Location -->
                @if($report->incident_location)
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Lokasi:</h3>
                        <p class="text-gray-700">
                            <i class="fas fa-map-marker-alt mr-2 text-primary-600"></i>
                            {{ $report->incident_location }}
                        </p>
                        @if($report->incident_address)
                            <p class="text-gray-600 text-sm ml-6 mt-1">{{ $report->incident_address }}</p>
                        @endif
                    </div>
                @endif

                <!-- Evidence Files -->
                @if($report->evidence_files)
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Bukti:</h3>
                        <div class="grid grid-cols-2 gap-4">
                            @php
                                $evidences = is_string($report->evidence_files) ? json_decode($report->evidence_files, true) : $report->evidence_files;
                            @endphp
                            @foreach($evidences ?? [] as $evidence)
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($evidence['path'] ?? $evidence) }}"
                                         alt="Bukti"
                                         class="w-full h-48 object-cover hover:scale-105 transition-transform cursor-pointer"
                                         onclick="window.open(this.src, '_blank')">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Admin Notes Display -->
                @if($report->admin_notes)
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="font-semibold text-blue-900 mb-2">
                            <i class="fas fa-comment-dots mr-2"></i>Catatan Admin
                        </h3>
                        <p class="text-blue-800 text-sm">{{ $report->admin_notes }}</p>
                    </div>
                @endif

                <!-- Resolution Notes Display -->
                @if($report->resolution_notes)
                    <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="font-semibold text-green-900 mb-2">
                            <i class="fas fa-check-circle mr-2"></i>Catatan Penyelesaian
                        </h3>
                        <p class="text-green-800 text-sm">{{ $report->resolution_notes }}</p>
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
                        <p class="font-mono font-semibold text-gray-900">{{ $report->report_number }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium mt-1">
                            {{ $report->category->name }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Dilaporkan pada</p>
                        <p class="text-gray-900">{{ $report->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Terakhir Update</p>
                        <p class="text-gray-900">{{ $report->updated_at->diffForHumans() }}</p>
                    </div>

                    @if($report->resolved_at)
                        <div>
                            <p class="text-sm text-gray-500">Diselesaikan pada</p>
                            <p class="text-gray-900">{{ $report->resolved_at->format('d M Y, H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reporter Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Pelapor</h3>

                @if($report->user)
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
                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <p class="text-sm text-gray-500">Telepon</p>
                            <p class="text-gray-900">{{ $report->user->phone }}</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-secret text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-500 text-sm">Laporan Anonim</p>
                    </div>
                @endif
            </div>

            <!-- Update Status Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Update Status</h3>

                <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" required>
                                <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewing" {{ $report->status == 'reviewing' ? 'selected' : '' }}>Sedang Ditinjau</option>
                                <option value="investigating" {{ $report->status == 'investigating' ? 'selected' : '' }}>Sedang Diselidiki</option>
                                <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                                <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                <option value="closed" {{ $report->status == 'closed' ? 'selected' : '' }}>Ditutup</option>
                            </select>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas</label>
                            <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="low" {{ $report->priority == 'low' ? 'selected' : '' }}>Rendah</option>
                                <option value="medium" {{ ($report->priority == 'medium' || !$report->priority) ? 'selected' : '' }}>Sedang</option>
                                <option value="high" {{ $report->priority == 'high' ? 'selected' : '' }}>Tinggi</option>
                                <option value="urgent" {{ $report->priority == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                            </select>
                        </div>

                        <!-- Severity -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tingkat Keparahan</label>
                            <select name="severity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="minor" {{ $report->severity == 'minor' ? 'selected' : '' }}>Ringan</option>
                                <option value="moderate" {{ ($report->severity == 'moderate' || !$report->severity) ? 'selected' : '' }}>Sedang</option>
                                <option value="serious" {{ $report->severity == 'serious' ? 'selected' : '' }}>Serius</option>
                                <option value="critical" {{ $report->severity == 'critical' ? 'selected' : '' }}>Kritis</option>
                            </select>
                        </div>

                        <!-- Admin Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin</label>
                            <textarea name="admin_notes"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                      placeholder="Tambahkan catatan...">{{ $report->admin_notes }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Update Status
                        </button>
                    </div>
                </form>

                <!-- Quick Actions -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-bolt text-yellow-500 mr-1"></i> Quick Actions:
                    </p>

                    <div class="space-y-2">
                        @if($report->status === 'pending')
                            <!-- Verifikasi -->
                            <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="reviewing">
                                <input type="hidden" name="priority" value="{{ $report->priority ?? 'medium' }}">
                                <input type="hidden" name="severity" value="{{ $report->severity ?? 'moderate' }}">
                                <input type="hidden" name="admin_notes" value="Laporan sedang ditinjau oleh tim">
                                <button type="submit" style="width: 100%; background-color: #059669; color: white; padding: 10px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-check" style="margin-right: 8px;"></i>
                                    Verifikasi
                                </button>
                            </form>
                            <!-- Tolak -->
                            <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST" style="margin-top: 8px;">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <input type="hidden" name="priority" value="{{ $report->priority ?? 'medium' }}">
                                <input type="hidden" name="severity" value="{{ $report->severity ?? 'moderate' }}">
                                <input type="hidden" name="admin_notes" value="Laporan ditolak">
                                <button type="submit" style="width: 100%; background-color: #dc2626; color: white; padding: 10px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; justify-content: center;" onclick="return confirm('Yakin ingin menolak laporan ini?')">
                                    <i class="fas fa-times" style="margin-right: 8px;"></i>
                                    Tolak
                                </button>
                            </form>

                        @elseif($report->status === 'reviewing')
                            <!-- Mulai Investigasi -->
                            <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="investigating">
                                <input type="hidden" name="priority" value="{{ $report->priority ?? 'medium' }}">
                                <input type="hidden" name="severity" value="{{ $report->severity ?? 'moderate' }}">
                                <input type="hidden" name="admin_notes" value="Laporan sedang diselidiki">
                                <button type="submit" style="width: 100%; background-color: #7c3aed; color: white; padding: 10px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-search" style="margin-right: 8px;"></i>
                                    Mulai Investigasi
                                </button>
                            </form>

                        @elseif($report->status === 'investigating')
                            <!-- Selesaikan -->
                            <form action="{{ route('admin.reports.updateStatus', $report->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="resolved">
                                <input type="hidden" name="priority" value="{{ $report->priority ?? 'medium' }}">
                                <input type="hidden" name="severity" value="{{ $report->severity ?? 'moderate' }}">
                                <input type="hidden" name="admin_notes" value="Laporan telah diselesaikan">
                                <button type="submit" style="width: 100%; background-color: #059669; color: white; padding: 10px; border-radius: 8px; font-weight: 600; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-check-double" style="margin-right: 8px;"></i>
                                    Selesaikan Laporan
                                </button>
                            </form>

                        @else
                            <!-- Status lain -->
                            <div style="text-align: center; padding: 12px; background-color: #f9fafb; border-radius: 8px; color: #6b7280; font-size: 14px;">
                                <i class="fas fa-info-circle" style="margin-right: 4px;"></i>
                                Status: <strong style="text-transform: capitalize;">{{ $report->status }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
