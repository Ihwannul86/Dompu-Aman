@extends('layouts.app')

@section('title', 'Buat Laporan - Dompu Aman')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-16">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl">
            <h1 class="text-4xl font-bold mb-4">Buat Laporan</h1>
            <p class="text-xl text-white/90">Laporkan kejadian atau masalah keamanan di sekitar Anda</p>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" id="reportForm">
                    @csrf

                    <!-- Category -->
                    <div class="mb-6">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id"
                                name="category_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('category_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Incident Type -->
                    <div class="mb-6">
                        <label for="incident_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Insiden
                        </label>
                        <select id="incident_type"
                                name="incident_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="umum" {{ old('incident_type') == 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="darurat" {{ old('incident_type') == 'darurat' ? 'selected' : '' }}>Darurat</option>
                            <option value="kriminal" {{ old('incident_type') == 'kriminal' ? 'selected' : '' }}>Kriminal</option>
                            <option value="sosial" {{ old('incident_type') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                            <option value="lingkungan" {{ old('incident_type') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                        </select>
                        @error('incident_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-6">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi Kejadian <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="location"
                               name="location"
                               value="{{ old('location') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('location') border-red-500 @enderror"
                               placeholder="Contoh: Jl. Pahlawan, Kelurahan Kendo"
                               required>
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Detailed Address -->
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Lengkap (Opsional)
                        </label>
                        <input type="text"
                               id="address"
                               name="address"
                               value="{{ old('address') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                               placeholder="Contoh: No. 123, RT 02/RW 03">
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Kejadian <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   id="date"
                                   name="date"
                                   value="{{ old('date', date('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('date') border-red-500 @enderror"
                                   required>
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Kejadian (Opsional)
                            </label>
                            <input type="time"
                                   id="time"
                                   name="time"
                                   value="{{ old('time') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            @error('time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Kejadian <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="6"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Jelaskan kronologi kejadian secara detail..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">Minimal 20 karakter. Jelaskan kronologi kejadian secara detail.</p>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Bukti Foto (Opsional)
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG (MAX. 2MB)</p>
                                </div>
                                <input id="image"
                                       name="image"
                                       type="file"
                                       class="hidden"
                                       accept="image/jpeg,image/png,image/jpg"
                                       onchange="previewImage(event)">
                            </label>
                        </div>
                        <div id="imagePreview" class="mt-4 hidden">
                            <img src="" alt="Preview" class="max-w-full h-48 rounded-lg mx-auto">
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Privacy Notice -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                            <div>
                                <h4 class="font-semibold text-blue-900 mb-1">Informasi Privasi</h4>
                                <p class="text-sm text-blue-800">
                                    Laporan Anda akan ditinjau oleh tim kami. Data pribadi Anda akan dijaga kerahasiaannya sesuai dengan kebijakan privasi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('reports.index') }}" class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Preview image upload
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const img = preview.querySelector('img');

    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(event.target.files[0]);
    }
}

// Auto refresh CSRF token every 10 minutes to prevent 419 error
setInterval(function() {
    fetch('/refresh-csrf')
        .then(response => response.json())
        .then(data => {
            document.querySelector('input[name="_token"]').value = data.token;
            console.log('CSRF token refreshed successfully');
        })
        .catch(error => {
            console.error('Failed to refresh CSRF token:', error);
        });
}, 600000); // 10 minutes

// Handle form submit - check if session expired
document.getElementById('reportForm').addEventListener('submit', function(e) {
    const token = document.querySelector('input[name="_token"]').value;

    if (!token || token === '') {
        e.preventDefault();
        alert('Session expired! Halaman akan di-refresh. Silakan submit ulang laporan Anda.');
        location.reload();
        return false;
    }

    // Show loading indicator
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
});
</script>
@endpush
@endsection
