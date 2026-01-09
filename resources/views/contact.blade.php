@extends('layouts.app')

@section('title', 'Hubungi Kami - Dompu Aman')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-secondary-600 text-white py-20">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Hubungi Kami</h1>
            <p class="text-xl text-white/90">Ada pertanyaan atau saran? Kami siap membantu Anda</p>
        </div>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 max-w-6xl mx-auto">
            <!-- Contact Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-primary-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Alamat</h3>
                            <p class="text-gray-600 text-sm">
                                Jl. Soekarno-Hatta No. 1<br>
                                Dompu, NTB 84217
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Telepon</h3>
                            <p class="text-gray-600 text-sm">
                                +62 812-3456-7890<br>
                                (Senin - Jumat, 08:00 - 17:00)
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600 text-sm">
                                info@dompuaman.com<br>
                                support@dompuaman.com
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Ikuti Kami</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Facebook -->
                        <a href="https://facebook.com/dompuaman"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex flex-col items-center justify-center p-4 bg-blue-600 rounded-lg text-white hover:bg-blue-700 transition-all hover:scale-105">
                            <i class="fab fa-facebook-f text-2xl mb-2"></i>
                            <span class="text-xs font-medium">Facebook</span>
                        </a>

                        <!-- Twitter -->
                        <a href="https://twitter.com/dompuaman"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex flex-col items-center justify-center p-4 bg-sky-500 rounded-lg text-white hover:bg-sky-600 transition-all hover:scale-105">
                            <i class="fab fa-twitter text-2xl mb-2"></i>
                            <span class="text-xs font-medium">Twitter</span>
                        </a>

                        <!-- Instagram -->
                        <a href="https://instagram.com/dompuaman"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex flex-col items-center justify-center p-4 bg-pink-600 rounded-lg text-white hover:bg-pink-700 transition-all hover:scale-105">
                            <i class="fab fa-instagram text-2xl mb-2"></i>
                            <span class="text-xs font-medium">Instagram</span>
                        </a>

                        <!-- WhatsApp -->
                        <a href="https://wa.me/6281234567890"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex flex-col items-center justify-center p-4 bg-green-500 rounded-lg text-white hover:bg-green-600 transition-all hover:scale-105">
                            <i class="fab fa-whatsapp text-2xl mb-2"></i>
                            <span class="text-xs font-medium">WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                    <form action="#" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="John Doe"
                                       required>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="john@example.com"
                                       required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                            <input type="text"
                                   id="subject"
                                   name="subject"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                   placeholder="Apa yang bisa kami bantu?"
                                   required>
                        </div>

                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                            <textarea id="message"
                                      name="message"
                                      rows="6"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                      placeholder="Tulis pesan Anda di sini..."
                                      required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-full md:w-auto">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
