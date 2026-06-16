<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@taskmaster.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // Students
        $student1 = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@student.com',
            'password' => Hash::make('password'),
            'role'     => 'student',
            'nim'      => '2021001',
            'jurusan'  => 'Teknik Informatika',
            'semester' => '6',
        ]);

        $student2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@student.com',
            'password' => Hash::make('password'),
            'role'     => 'student',
            'nim'      => '2021002',
            'jurusan'  => 'Sistem Informasi',
            'semester' => '4',
        ]);

        // Categories
        $categories = [
            ['name' => 'Pemrograman',    'color' => '#6366f1', 'icon' => '💻'],
            ['name' => 'Matematika',     'color' => '#f59e0b', 'icon' => '📐'],
            ['name' => 'Bahasa Inggris', 'color' => '#10b981', 'icon' => '🌐'],
            ['name' => 'Jaringan',       'color' => '#3b82f6', 'icon' => '🔌'],
            ['name' => 'Database',       'color' => '#ef4444', 'icon' => '🗄️'],
            ['name' => 'Proyek',         'color' => '#8b5cf6', 'icon' => '🚀'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Tasks for student1
        $tasks = [
            [
                'title'       => 'Tugas Laravel CRUD',
                'description' => 'Membuat aplikasi manajemen tugas menggunakan Laravel dengan fitur CRUD lengkap.',
                'priority'    => 'urgent',
                'status'      => 'in_progress',
                'due_date'    => now()->addDays(3),
                'mata_kuliah' => 'Pemrograman Web',
                'dosen'       => 'Dr. Ahmad Fauzi',
                'category_id' => 1,
                'progress'    => 60,
                'is_pinned'   => true,
            ],
            [
                'title'       => 'UTS Kalkulus',
                'description' => 'Persiapan ujian tengah semester mata kuliah kalkulus lanjut.',
                'priority'    => 'high',
                'status'      => 'todo',
                'due_date'    => now()->addDays(7),
                'mata_kuliah' => 'Kalkulus Lanjut',
                'dosen'       => 'Prof. Budi Hartono',
                'category_id' => 2,
                'progress'    => 0,
                'is_pinned'   => false,
            ],
            [
                'title'       => 'Presentasi TOEFL',
                'description' => 'Presentasi preparation TOEFL untuk kelas Bahasa Inggris.',
                'priority'    => 'medium',
                'status'      => 'done',
                'due_date'    => now()->subDays(2),
                'mata_kuliah' => 'Bahasa Inggris',
                'dosen'       => 'Mrs. Sarah Johnson',
                'category_id' => 3,
                'progress'    => 100,
                'is_pinned'   => false,
            ],
            [
                'title'       => 'Laporan Jaringan Komputer',
                'description' => 'Laporan praktikum konfigurasi VLAN dan routing.',
                'priority'    => 'medium',
                'status'      => 'in_progress',
                'due_date'    => now()->addDays(5),
                'mata_kuliah' => 'Jaringan Komputer',
                'dosen'       => 'Dr. Wahyu Pratama',
                'category_id' => 4,
                'progress'    => 40,
                'is_pinned'   => false,
            ],
            [
                'title'       => 'ERD dan Implementasi Database',
                'description' => 'Membuat ERD dan mengimplementasikan database untuk studi kasus toko online.',
                'priority'    => 'high',
                'status'      => 'todo',
                'due_date'    => now()->addDays(10),
                'mata_kuliah' => 'Basis Data',
                'dosen'       => 'Ir. Dewi Kurnia',
                'category_id' => 5,
                'progress'    => 10,
                'is_pinned'   => false,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create(array_merge($task, ['user_id' => $student1->id]));
        }

        // Tasks for student2
        Task::create([
            'user_id'     => $student2->id,
            'title'       => 'Analisis Sistem Informasi',
            'description' => 'Membuat dokumen analisis kebutuhan sistem untuk proyek akhir.',
            'priority'    => 'urgent',
            'status'      => 'in_progress',
            'due_date'    => now()->addDays(2),
            'mata_kuliah' => 'Analisis Sistem',
            'dosen'       => 'Dr. Indra Kusuma',
            'category_id' => 6,
            'progress'    => 75,
            'is_pinned'   => true,
        ]);
    }
}
