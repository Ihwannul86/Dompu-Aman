<nav class="bg-white shadow-md sticky top-0 z-50" x-data="{ mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="h-10 w-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gradient">Dompu Aman</h1>
                        <p class="text-xs text-gray-500">Platform Edukasi & Pelaporan</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-500 font-medium transition {{ request()->routeIs('home') ? 'text-primary-500' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('articles.index') }}" class="text-gray-700 hover:text-primary-500 font-medium transition {{ request()->routeIs('articles.*') ? 'text-primary-500' : '' }}">
                    Artikel
                </a>
                <a href="{{ route('forums.index') }}" class="text-gray-700 hover:text-primary-500 font-medium transition {{ request()->routeIs('forums.*') ? 'text-primary-500' : '' }}">
                    Forum
                </a>
                <a href="{{ route('reports.create') }}" class="text-gray-700 hover:text-primary-500 font-medium transition {{ request()->routeIs('reports.*') ? 'text-primary-500' : '' }}">
                    Laporkan
                </a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary-500 font-medium transition {{ request()->routeIs('about') ? 'text-primary-500' : '' }}">
                    Tentang
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isModerator())
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-primary-500 font-medium">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                    @endif

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <img src="{{ get_avatar(auth()->user(), 32) }}" alt="{{ auth()->user()->name }}" class="h-8 w-8 rounded-full border-2 border-primary-500">
                            <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                        </button>

                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2"
                             style="display: none;">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil
                            </a>
                            <a href="{{ route('reports.track') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-file-alt mr-2"></i> Laporan Saya
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-500 font-medium">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary">
                        Daftar
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="mobileMenu = !mobileMenu" class="text-gray-700 hover:text-primary-500 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" class="md:hidden bg-white border-t" style="display: none;">
        <div class="px-4 pt-2 pb-4 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Beranda
            </a>
            <a href="{{ route('articles.index') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Artikel
            </a>
            <a href="{{ route('forums.index') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Forum
            </a>
            <a href="{{ route('reports.create') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Laporkan
            </a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                Tentang
            </a>

            @auth
                @if(auth()->user()->isAdmin() || auth()->user()->isModerator())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                @endif
                <hr class="my-2">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-red-600 hover:bg-gray-100 font-medium">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            @else
                <hr class="my-2">
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100 font-medium">
                    Masuk
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md bg-primary-500 text-white hover:bg-primary-600 font-medium text-center">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
