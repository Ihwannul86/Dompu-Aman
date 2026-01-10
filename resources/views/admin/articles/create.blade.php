@extends('layouts.admin')

@section('title', 'Tambah Artikel - Admin Dompu Aman')

@section('content')
<div class="p-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ url('/admin/articles') }}" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Artikel
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Artikel Baru</h2>

        <form action="{{ url('/admin/articles') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Article Type -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Tipe Artikel <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-start p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-primary-500 transition article-type-card">
                            <input type="radio"
                                   name="article_type"
                                   value="internal"
                                   checked
                                   class="mt-1 mr-3 w-5 h-5 text-primary-600"
                                   onchange="toggleArticleType()">
                            <div>
                                <span class="font-semibold text-gray-900 block">📝 Artikel Internal</span>
                                <p class="text-sm text-gray-600 mt-1">Tulis artikel sendiri dengan konten lengkap</p>
                            </div>
                        </label>
                        <label class="flex items-start p-4 bg-white border-2 border-gray-300 rounded-lg cursor-pointer hover:border-primary-500 transition article-type-card">
                            <input type="radio"
                                   name="article_type"
                                   value="external"
                                   class="mt-1 mr-3 w-5 h-5 text-primary-600"
                                   onchange="toggleArticleType()">
                            <div>
                                <span class="font-semibold text-gray-900 block">🔗 Artikel Eksternal</span>
                                <p class="text-sm text-gray-600 mt-1">Masukkan URL dari sumber terpercaya</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- INTERNAL ARTICLE FIELDS -->
                <div id="internal_fields">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Artikel <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="mt-4">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                            Ringkasan
                        </label>
                        <textarea name="excerpt"
                                  id="excerpt"
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
                                  placeholder="Ringkasan singkat artikel...">{{ old('excerpt') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">
                            <i class="fas fa-magic mr-1"></i>
                            Opsional - Auto-generate dari konten jika kosong
                        </p>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mt-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Konten <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content"
                                  id="content"
                                  rows="10"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- EXTERNAL ARTICLE FIELDS -->
                <div id="external_fields" style="display: none;">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-lg p-5">
                        <div class="flex items-start space-x-3 mb-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-link text-white text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">Artikel Eksternal</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Cukup masukkan URL artikel, judul dan konten akan diambil otomatis dari sumber
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="external_url" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-globe mr-2 text-blue-600"></i>
                                URL Artikel <span class="text-red-500">*</span>
                            </label>
                            <input type="url"
                                   name="external_url"
                                   id="external_url"
                                   value="{{ old('external_url') }}"
                                   class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('external_url') border-red-500 @enderror"
                                   placeholder="https://kompas.com/artikel-keamanan atau https://detik.com/berita-terkini">
                            <p class="mt-2 text-sm text-gray-600 bg-white rounded px-3 py-2 border border-gray-200">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                <strong>Contoh URL:</strong> Kompas.com, Detik.com, CNN Indonesia, Tempo.co, dll
                            </p>
                            @error('external_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Category (SELALU TAMPIL) -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-folder mr-2"></i>
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id"
                            id="category_id"
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
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured Image (SELALU TAMPIL) -->
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image mr-2"></i>
                        Gambar Utama <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <input type="file"
                               name="featured_image"
                               id="featured_image"
                               accept="image/*"
                               class="hidden"
                               onchange="displayFileName(this)"
                               required>

                        <label for="featured_image"
                               class="flex items-center justify-center w-full px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-lg cursor-pointer transition-all duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-cloud-upload-alt text-2xl mr-3"></i>
                            <span id="file-label">Pilih Gambar Artikel</span>
                        </label>

                        <div id="file-preview" class="mt-3 hidden">
                            <div class="flex items-center p-3 bg-green-50 border border-green-200 rounded-lg">
                                <i class="fas fa-image text-green-600 text-2xl mr-3"></i>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-green-800" id="file-name"></p>
                                    <p class="text-xs text-green-600" id="file-size"></p>
                                </div>
                                <button type="button"
                                        onclick="clearFile()"
                                        class="text-red-500 hover:text-red-700 ml-2">
                                    <i class="fas fa-times-circle text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Format: JPG, PNG | Max: 5MB | <strong>Wajib diupload untuk tampilan menarik</strong>
                    </p>
                    @error('featured_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status (SELALU TAMPIL) -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-2"></i>
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            id="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('status') border-red-500 @enderror"
                            required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                    <a href="{{ url('/admin/articles') }}"
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Artikel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Display file name preview
function displayFileName(input) {
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const fileLabel = document.getElementById('file-label');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const sizeInMB = (file.size / 1024 / 1024).toFixed(2);

        fileName.textContent = file.name;
        fileSize.textContent = `Ukuran: ${sizeInMB} MB`;
        filePreview.classList.remove('hidden');
        fileLabel.textContent = 'Ganti Gambar';
    }
}

// Clear selected file
function clearFile() {
    const input = document.getElementById('featured_image');
    const filePreview = document.getElementById('file-preview');
    const fileLabel = document.getElementById('file-label');

    input.value = '';
    filePreview.classList.add('hidden');
    fileLabel.textContent = 'Pilih Gambar Artikel';
}

// Toggle between internal and external article
function toggleArticleType() {
    const type = document.querySelector('input[name="article_type"]:checked').value;
    const internalFields = document.getElementById('internal_fields');
    const externalFields = document.getElementById('external_fields');
    const titleField = document.getElementById('title');
    const contentField = document.getElementById('content');
    const externalUrl = document.getElementById('external_url');

    // Update card borders
    document.querySelectorAll('.article-type-card').forEach(card => {
        card.classList.remove('border-primary-500', 'bg-primary-50');
    });

    const selectedCard = document.querySelector(`input[value="${type}"]`).closest('.article-type-card');
    selectedCard.classList.add('border-primary-500', 'bg-primary-50');

    if (type === 'external') {
        // Show external fields, hide internal fields
        internalFields.style.display = 'none';
        externalFields.style.display = 'block';

        // Make fields optional/required
        titleField.required = false;
        contentField.required = false;
        externalUrl.required = true;
    } else {
        // Show internal fields, hide external fields
        internalFields.style.display = 'block';
        externalFields.style.display = 'none';

        // Make fields optional/required
        titleField.required = true;
        contentField.required = true;
        externalUrl.required = false;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleArticleType();
});
</script>
@endsection
