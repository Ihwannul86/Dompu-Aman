<nav class="bg-white shadow-md sticky top-0 z-50" x-data="{ mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo - With Emoji Shield -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <!-- Shield Icon Container -->
                    <div class="h-12 w-12 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-300" style="background-color: #6366f1;">
                        <span class="text-3xl">🛡️</span>
                    </div>

                    <!-- Logo Text -->
                    <div>
                        <h1 class="text-xl font-bold" style="color: #6366f1;">Dompu Aman</h1>
                        <p class="text-xs" style="color: #9ca3af;">Platform Edukasi & Pelaporan</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="relative text-gray-700 hover:text-primary-600 font-medium transition-colors duration-300 {{ request()->routeIs('home') ? 'text-primary-600' : '' }}">
                    Beranda
                    @if(request()->routeIs('home'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('articles.index') }}" class="relative text-gray-700 hover:text-primary-600 font-medium transition-colors duration-300 {{ request()->routeIs('articles.*') ? 'text-primary-600' : '' }}">
                    Artikel
                    @if(request()->routeIs('articles.*'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('forums.index') }}" class="relative text-gray-700 hover:text-primary-600 font-medium transition-colors duration-300 {{ request()->routeIs('forums.*') ? 'text-primary-600' : '' }}">
                    Forum
                    @if(request()->routeIs('forums.*'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('reports.index') }}" class="relative text-gray-700 hover:text-primary-600 font-medium transition-colors duration-300 {{ request()->routeIs('reports.*') ? 'text-primary-600' : '' }}">
                    Laporan
                    @if(request()->routeIs('reports.*'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('about') }}" class="relative text-gray-700 hover:text-primary-600 font-medium transition-colors duration-300 {{ request()->routeIs('about') ? 'text-primary-600' : '' }}">
                    Tentang
                    @if(request()->routeIs('about'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full"></span>
                    @endif
                </a>
                <a href="{{ route('contact') }}" class="relative text-gray-700 hover:text-primary-600 font-medium transition-colors duration-300 {{ request()->routeIs('contact') ? 'text-primary-600' : '' }}">
                    Kontak
                    @if(request()->routeIs('contact'))
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full"></span>
                    @endif
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium transition-colors duration-300">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none group">
                            <div class="h-8 w-8 rounded-full flex items-center justify-center border-2 border-blue-500 group-hover:border-purple-500 transition-all duration-300 group-hover:scale-110" style="background: linear-gradient(to bottom right, #dbeafe, #e9d5ff);">
                                <i class="fas fa-user text-blue-600 group-hover:text-purple-600 transition-colors duration-300"></i>
                            </div>
                            <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-300">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs group-hover:text-blue-600 transition-colors duration-300"></i>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50"
                             style="display: none;">
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200">
                                <i class="fas fa-user mr-3 text-blue-600"></i>
                                <span>Profil</span>
                            </a>
                            <a href="{{ route('reports.track') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200">
                                <i class="fas fa-search mr-3 text-purple-600"></i>
                                <span>Lacak Laporan</span>
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-all duration-200">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- UPDATED: Kedua tombol pakai gradient yang sama -->
                    <a href="{{ route('login') }}" class="px-6 py-2 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300" style="background: linear-gradient(to right, #6366f1, #8b5cf6);">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300" style="background: linear-gradient(to right, #6366f1, #8b5cf6);">
                        Daftar
                    </a>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="mobileMenu = !mobileMenu" class="text-gray-700 hover:text-primary-600 focus:outline-none transition-colors duration-300">
                    <i class="fas text-2xl" :class="mobileMenu ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="md:hidden bg-white border-t"
         style="display: none;">
        <div class="px-4 pt-2 pb-4 space-y-2">
            <a href="{{ route('home') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : '' }}">
                <i class="fas fa-home mr-3 w-5"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('articles.index') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 font-medium transition-all duration-200 {{ request()->routeIs('articles.*') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : '' }}">
                <i class="fas fa-newspaper mr-3 w-5"></i>
                <span>Artikel</span>
            </a>
            <a href="{{ route('forums.index') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 font-medium transition-all duration-200 {{ request()->routeIs('forums.*') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : '' }}">
                <i class="fas fa-comments mr-3 w-5"></i>
                <span>Forum</span>
            </a>
            <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 font-medium transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : '' }}">
                <i class="fas fa-flag mr-3 w-5"></i>
                <span>Laporan</span>
            </a>
            <a href="{{ route('about') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 font-medium transition-all duration-200 {{ request()->routeIs('about') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : '' }}">
                <i class="fas fa-info-circle mr-3 w-5"></i>
                <span>Tentang</span>
            </a>
            <a href="{{ route('contact') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 font-medium transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600' : '' }}">
                <i class="fas fa-envelope mr-3 w-5"></i>
                <span>Kontak</span>
            </a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="border-t border-gray-200 my-3"></div>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 font-medium transition-all duration-200">
                        <i class="fas fa-tachometer-alt mr-3 w-5"></i>
                        <span>Dashboard Admin</span>
                    </a>
                @endif
                <div class="border-t border-gray-200 my-3"></div>
                <a href="{{ route('reports.track') }}" class="flex items-center px-3 py-2 rounded-lg text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-blue-600 font-medium transition-all duration-200">
                    <i class="fas fa-search mr-3 w-5"></i>
                    <span>Lacak Laporan</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 font-medium transition-all duration-200">
                        <i class="fas fa-sign-out-alt mr-3 w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @else
                <div class="border-t border-gray-200 my-3"></div>
                <!-- UPDATED: Kedua tombol gradient di mobile -->
                <a href="{{ route('login') }}" class="flex items-center justify-center px-3 py-2 rounded-lg text-white font-medium text-center transition-all duration-300" style="background: linear-gradient(to right, #6366f1, #8b5cf6);">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    <span>Masuk</span>
                </a>
                <a href="{{ route('register') }}" class="flex items-center justify-center px-3 py-2 rounded-lg text-white font-medium text-center transition-all duration-300" style="background: linear-gradient(to right, #6366f1, #8b5cf6);">
                    <i class="fas fa-user-plus mr-2"></i>
                    <span>Daftar</span>
                </a>
            @endauth
        </div>
    </div>
</nav>
