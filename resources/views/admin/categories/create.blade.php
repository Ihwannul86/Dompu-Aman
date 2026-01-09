@extends('layouts.admin')

@section('title', 'Tambah Kategori - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Kategori
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Kategori Baru</h2>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="Contoh: Kriminalitas"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-6">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="slug"
                           name="slug"
                           value="{{ old('slug') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="Contoh: kriminalitas"
                           required>
                    <p class="text-sm text-gray-500 mt-1">URL-friendly version (hanya huruf kecil, angka, dan dash)</p>
                    @error('slug')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div class="mb-6">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe <span class="text-red-500">*</span>
                    </label>
                    <select id="type"
                            name="type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required>
                        <option value="">Pilih Tipe</option>
                        <option value="report" {{ old('type') == 'report' ? 'selected' : '' }}>Laporan</option>
                        <option value="article" {{ old('type') == 'article' ? 'selected' : '' }}>Artikel</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                              placeholder="Deskripsi singkat tentang kategori ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div class="mb-6">
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                        Icon (Font Awesome)
                    </label>
                    <input type="text"
                           id="icon"
                           name="icon"
                           value="{{ old('icon') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           placeholder="Contoh: fa-shield-alt">
                    <p class="text-sm text-gray-500 mt-1">Gunakan class Font Awesome (contoh: fa-flag, fa-book)</p>
                    @error('icon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color -->
                <div class="mb-6">
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                        Warna (Tailwind CSS)
                    </label>
                    <select id="color"
                            name="color"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Pilih Warna</option>
                        <option value="bg-red-500" {{ old('color') == 'bg-red-500' ? 'selected' : '' }}>Merah</option>
                        <option value="bg-orange-500" {{ old('color') == 'bg-orange-500' ? 'selected' : '' }}>Orange</option>
                        <option value="bg-yellow-500" {{ old('color') == 'bg-yellow-500' ? 'selected' : '' }}>Kuning</option>
                        <option value="bg-green-500" {{ old('color') == 'bg-green-500' ? 'selected' : '' }}>Hijau</option>
                        <option value="bg-blue-500" {{ old('color') == 'bg-blue-500' ? 'selected' : '' }}>Biru</option>
                        <option value="bg-purple-500" {{ old('color') == 'bg-purple-500' ? 'selected' : '' }}>Ungu</option>
                        <option value="bg-pink-500" {{ old('color') == 'bg-pink-500' ? 'selected' : '' }}>Pink</option>
                        <option value="bg-gray-500" {{ old('color') == 'bg-gray-500' ? 'selected' : '' }}>Abu-abu</option>
                    </select>
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.categories.index') }}" class="btn bg-gray-100 text-gray-700 hover:bg-gray-200">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto generate slug from name
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    });
</script>
@endpush
@endsection
