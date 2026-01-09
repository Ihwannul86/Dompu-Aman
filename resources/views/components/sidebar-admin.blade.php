<aside id="sidebar" class="w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full fixed lg:relative z-30 h-full">
    <div class="flex flex-col h-full">

        <!-- Sidebar Header -->
        <div class="flex items-center justify-between px-6 py-4 bg-gradient-primary">
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 bg-white rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-primary-500 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Dompu Aman</h2>
                    <p class="text-xs text-white opacity-80">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tachometer-alt text-lg"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Articles -->
            <div x-data="{ open: {{ request()->routeIs('admin.articles.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.articles.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-newspaper text-lg"></i>
                        <span class="font-medium">Artikel</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>
                <div x-show="open" class="ml-4 mt-2 space-y-1" style="display: none;">
                    <a href="{{ route('admin.articles.index') }}"
                       class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin.articles.index') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-list"></i>
                        <span>Semua Artikel</span>
                    </a>
                    <a href="{{ route('admin.articles.create') }}"
                       class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin.articles.create') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-plus"></i>
                        <span>Buat Artikel</span>
                    </a>
                </div>
            </div>

            <!-- Reports -->
            <div x-data="{ open: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.reports.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-file-alt text-lg"></i>
                        <span class="font-medium">Laporan</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>
                <div x-show="open" class="ml-4 mt-2 space-y-1" style="display: none;">
                    <a href="{{ route('admin.reports.index') }}"
                       class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin.reports.index') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-list"></i>
                        <span>Semua Laporan</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}?status=pending"
                       class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-clock"></i>
                        <span>Pending</span>
                        @if(App\Models\Report::where('status', 'pending')->count() > 0)
                            <span class="ml-auto bg-yellow-500 text-white text-xs px-2 py-0.5 rounded-full">
                                {{ App\Models\Report::where('status', 'pending')->count() }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('admin.reports.index') }}?status=resolved"
                       class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-check-circle"></i>
                        <span>Selesai</span>
                    </a>
                </div>
            </div>

            <!-- Forums -->
            <div x-data="{ open: {{ request()->routeIs('admin.forums.*') ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.forums.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-comments text-lg"></i>
                        <span class="font-medium">Forum</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>
                <div x-show="open" class="ml-4 mt-2 space-y-1" style="display: none;">
                    <a href="{{ route('admin.forums.index') }}"
                       class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm {{ request()->routeIs('admin.forums.index') ? 'bg-primary-50 text-primary-600' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-list"></i>
                        <span>Semua Forum</span>
                    </a>
                </div>
            </div>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.categories.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-tags text-lg"></i>
                <span class="font-medium">Kategori</span>
            </a>

            <!-- Users (Admin Only) -->
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-users text-lg"></i>
                    <span class="font-medium">Pengguna</span>
                </a>
            @endif

            <hr class="my-4">

            <!-- Back to Website -->
            <a href="{{ route('home') }}"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                <i class="fas fa-globe text-lg"></i>
                <span class="font-medium">Lihat Website</span>
            </a>

        </nav>

        <!-- Sidebar Footer -->
        <div class="px-6 py-4 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                <img src="{{ get_avatar(auth()->user(), 40) }}" alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-full border-2 border-primary-500">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
        </div>

    </div>
</aside>
