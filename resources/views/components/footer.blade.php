<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Brand -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="h-10 w-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Dompu Aman</h3>
                        <p class="text-sm text-gray-400">Platform Edukasi & Pelaporan Sosial</p>
                    </div>
                </div>
                <p class="text-gray-400 mb-4">
                    Platform berbasis komunitas untuk meningkatkan kesadaran masyarakat dalam mencegah kekerasan antar remaja di Kabupaten Dompu.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-twitter text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-youtube text-2xl"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-4">Menu Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                    <li><a href="{{ route('articles.index') }}" class="hover:text-white transition">Artikel Edukasi</a></li>
                    <li><a href="{{ route('forums.index') }}" class="hover:text-white transition">Forum Diskusi</a></li>
                    <li><a href="{{ route('reports.create') }}" class="hover:text-white transition">Laporkan Kekerasan</a></li>
                    <li><a href="{{ route('reports.track') }}" class="hover:text-white transition">Lacak Laporan</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-white font-semibold mb-4">Kontak</h4>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary-400"></i>
                        <span>Kabupaten Dompu, Nusa Tenggara Barat</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mt-1 mr-3 text-primary-400"></i>
                        <span>+62 xxx xxxx xxxx</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mt-1 mr-3 text-primary-400"></i>
                        <span>admin@dompuaman.com</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 mt-8 pt-8 text-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} Dompu Aman. All rights reserved.
                <span class="mx-2">|</span>
                Developed for Tugas Akhir
            </p>
        </div>
    </div>
</footer>
