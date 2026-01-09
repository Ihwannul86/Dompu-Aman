<!-- Sidebar -->
<aside class="w-64 bg-white shadow-lg flex-shrink-0">
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="p-6 border-b border-gray-200">
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="font-bold text-gray-900">Dompu Aman</h2>
                    <p class="text-xs text-gray-500">Admin Panel</p>
                </div>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto p-4">
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} transition">
                        <i class="fas fa-home w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                <!-- Reports -->
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} transition">
                        <i class="fas fa-flag w-5"></i>
                        <span class="font-medium">Laporan</span>
                        @if(isset($pendingReports) && $pendingReports > 0)
                            <span class="ml-auto badge badge-warning">{{ $pendingReports }}</span>
                        @endif
                    </a>
                </li>

                <!-- Articles -->
                <li>
                    <a href="{{ route('admin.articles.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.articles.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} transition">
                        <i class="fas fa-newspaper w-5"></i>
                        <span class="font-medium">Artikel</span>
                    </a>
                </li>

                <!-- Forums -->
                <li>
                    <a href="{{ route('admin.forums.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.forums.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} transition">
                        <i class="fas fa-comments w-5"></i>
                        <span class="font-medium">Forum</span>
                    </a>
                </li>

                <!-- Users -->
                <li>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} transition">
                        <i class="fas fa-users w-5"></i>
                        <span class="font-medium">Pengguna</span>
                    </a>
                </li>

                <!-- Categories -->
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-100' }} transition">
                        <i class="fas fa-folder w-5"></i>
                        <span class="font-medium">Kategori</span>
                    </a>
                </li>

                <!-- Divider -->
                <li class="pt-4 mt-4 border-t border-gray-200">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        <i class="fas fa-globe w-5"></i>
                        <span class="font-medium">Lihat Website</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
