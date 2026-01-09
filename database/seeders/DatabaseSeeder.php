<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Dompu Aman',
            'email' => 'admin@dompuaman.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create Moderator User
        User::create([
            'name' => 'Moderator',
            'email' => 'moderator@dompuaman.com',
            'password' => Hash::make('password123'),
            'role' => 'moderator',
            'status' => 'active',
        ]);

        // Create Test User
        User::create([
            'name' => 'User Test',
            'email' => 'user@dompuaman.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'status' => 'active',
        ]);

        // Create Categories for Articles
        $articleCategories = [
            ['name' => 'Pencegahan Kekerasan', 'slug' => 'pencegahan-kekerasan', 'type' => 'article', 'icon' => 'shield', 'color' => '#10B981'],
            ['name' => 'Etika Sosial', 'slug' => 'etika-sosial', 'type' => 'article', 'icon' => 'users', 'color' => '#3B82F6'],
            ['name' => 'Kesehatan Mental', 'slug' => 'kesehatan-mental', 'type' => 'article', 'icon' => 'heart', 'color' => '#EF4444'],
            ['name' => 'Hukum & Peraturan', 'slug' => 'hukum-peraturan', 'type' => 'article', 'icon' => 'book', 'color' => '#8B5CF6'],
        ];

        // Create Categories for Reports
        $reportCategories = [
            ['name' => 'Perkelahian/Tawuran', 'slug' => 'perkelahian-tawuran', 'type' => 'report', 'icon' => 'alert', 'color' => '#DC2626'],
            ['name' => 'Bullying/Intimidasi', 'slug' => 'bullying-intimidasi', 'type' => 'report', 'icon' => 'warning', 'color' => '#F59E0B'],
            ['name' => 'Penyalahgunaan Minuman Keras', 'slug' => 'minuman-keras', 'type' => 'report', 'icon' => 'x-circle', 'color' => '#7C3AED'],
            ['name' => 'Tindak Asusila', 'slug' => 'tindak-asusila', 'type' => 'report', 'icon' => 'shield-exclamation', 'color' => '#EC4899'],
            ['name' => 'Kekerasan Verbal', 'slug' => 'kekerasan-verbal', 'type' => 'report', 'icon' => 'chat', 'color' => '#F97316'],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'type' => 'report', 'icon' => 'dots', 'color' => '#6B7280'],
        ];

        // Create Categories for Forums
        $forumCategories = [
            ['name' => 'Cerita Inspiratif', 'slug' => 'cerita-inspiratif', 'type' => 'forum', 'icon' => 'star', 'color' => '#FBBF24'],
            ['name' => 'Kegiatan Positif', 'slug' => 'kegiatan-positif', 'type' => 'forum', 'icon' => 'thumb-up', 'color' => '#10B981'],
            ['name' => 'Diskusi Umum', 'slug' => 'diskusi-umum', 'type' => 'forum', 'icon' => 'chat-alt', 'color' => '#3B82F6'],
        ];

        $order = 1;
        foreach (array_merge($articleCategories, $reportCategories, $forumCategories) as $category) {
            Category::create(array_merge($category, [
                'description' => 'Kategori untuk ' . $category['name'],
                'is_active' => true,
                'order' => $order++,
            ]));
        }
    }
}
