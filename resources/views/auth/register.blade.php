@extends('layouts.app')

@section('title', 'Daftar - Dompu Aman')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-secondary-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="h-16 w-16 bg-gradient-primary rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
            <p class="text-gray-600">Bergabung dengan komunitas Dompu Aman</p>
        </div>

        <!-- Register Form Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="label">
                        <i class="fas fa-user mr-2 text-primary-500"></i>
                        Nama Lengkap
                    </label>
                    <input id="name"
                           type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autofocus
                           placeholder="Masukkan nama lengkap"
                           class="input-field @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="label">
                        <i class="fas fa-envelope mr-2 text-primary-500"></i>
                        Email
                    </label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="nama@email.com"
                           class="input-field @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="label">
                        <i class="fas fa-phone mr-2 text-primary-500"></i>
                        Nomor Telepon <span class="text-gray-400 text-xs">(Opsional)</span>
                    </label>
                    <input id="phone"
                           type="text"
                           name="phone"
                           value="{{ old('phone') }}"
                           placeholder="08xx xxxx xxxx"
                           class="input-field @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="label">
                        <i class="fas fa-lock mr-2 text-primary-500"></i>
                        Password
                    </label>
                    <div class="relative">
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               placeholder="Minimal 8 karakter"
                               class="input-field @error('password') border-red-500 @enderror">
                        <button type="button"
                                onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="label">
                        <i class="fas fa-lock mr-2 text-primary-500"></i>
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input id="password_confirmation"
                               type="password"
                               name="password_confirmation"
                               required
                               placeholder="Ketik ulang password"
                               class="input-field">
                        <button type="button"
                                onclick="togglePassword('password_confirmation')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i id="password_confirmation-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start">
                    <input id="terms"
                           type="checkbox"
                           required
                           class="h-4 w-4 mt-1 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        Saya setuju dengan
                        <a href="#" class="text-primary-600 hover:text-primary-500 font-medium">Syarat & Ketentuan</a>
                        dan
                        <a href="#" class="text-primary-600 hover:text-primary-500 font-medium">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full btn-primary btn-lg flex items-center justify-center space-x-2">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Sekarang</span>
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Sudah punya akun?</span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-500">
                        Masuk di sini
                    </a>
                </div>
            </form>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const passwordIcon = document.getElementById(inputId + '-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }

    // Password strength indicator (optional)
    const passwordInput = document.getElementById('password');
    passwordInput?.addEventListener('input', function() {
        const strength = calculatePasswordStrength(this.value);
        // You can add visual feedback here
    });

    function calculatePasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[$@#&!]+/)) strength++;
        return strength;
    }
</script>
@endpush
@endsection
