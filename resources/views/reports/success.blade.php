@extends('layouts.app')

@section('title', 'Laporan Berhasil Dikirim - Dompu Aman')

@section('content')
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-12 text-center">
            <!-- Success Icon -->
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-green-600 text-4xl"></i>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Laporan Berhasil Dikirim!</h1>

            <!-- Message -->
            <p class="text-lg text-gray-600 mb-8">
                Terima kasih telah melaporkan. Laporan Anda telah kami terima dan akan segera ditinjau oleh tim kami.
            </p>

            <!-- Report Number -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-8">
                <p class="text-sm text-gray-500 mb-2">Nomor Laporan Anda:</p>
                <p class="text-2xl font-bold font-mono text-primary-600">{{ $report->report_number }}</p>
                <p class="text-sm text-gray-500 mt-2">Simpan nomor ini untuk melacak status laporan Anda</p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('reports.track') }}" class="btn btn-primary">
                    <i class="fas fa-search mr-2"></i>
                    Lacak Laporan
                </a>
                <a href="{{ route('home') }}" class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-home mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
