<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Contoh (untuk Login Web & Flutter nanti)
        $user = User::updateOrCreate(
            ['email' => 'khai@test.com'],
            [
                'name' => 'Khai Developer',
                'password' => Hash::make('password123'), // Password: password123
            ]
        );

        // 2. Buat Kategori Contoh (dengan Icon & Color untuk Web/Mobile)
        $categories = [
            ['name' => 'Makanan', 'icon' => 'fastfood', 'color' => '#FF5733'],
            ['name' => 'Transport', 'icon' => 'directions_car', 'color' => '#3357FF'],
            ['name' => 'Hiburan', 'icon' => 'movie', 'color' => '#8E44AD'],
            ['name' => 'Bil & Utiliti', 'icon' => 'receipt', 'color' => '#F1C40F'],
        ];

        foreach ($categories as $cat) {
            $createdCat = Category::updateOrCreate(
                ['name' => $cat['name'], 'user_id' => $user->id],
                ['icon' => $cat['icon'], 'color' => $cat['color']]
            );

            // 3. Masukkan Data Belanja secara Rawak untuk setiap kategori
            // Kita buat data untuk bulan lepas dan bulan ni supaya Graf nampak cantik
            Expense::create([
                'user_id' => $user->id,
                'category_id' => $createdCat->id,
                'title' => 'Belanja ' . $cat['name'] . ' 1',
                'amount' => rand(10, 100),
                'spent_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);

            Expense::create([
                'user_id' => $user->id,
                'category_id' => $createdCat->id,
                'title' => 'Belanja ' . $cat['name'] . ' 2',
                'amount' => rand(10, 100),
                'spent_at' => Carbon::now(),
            ]);
        }
    }
}