<!-- Top Navbar -->
<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Page Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            </div>

            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- User Menu -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="text-left hidden md:block">
                            <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open"
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                         style="display: none;">
                        <a href="{{ route('dashboard.profile') }}" class="flex items-center space-x-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user w-5"></i>
                            <span>Profile</span>
                        </a>
                        <a href="{{ route('dashboard.index') }}" class="flex items-center space-x-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-tachometer-alt w-5"></i>
                            <span>My Dashboard</span>
                        </a>
                        <hr class="my-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-red-600 hover:bg-red-50 text-left">
                                <i class="fas fa-sign-out-alt w-5"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
