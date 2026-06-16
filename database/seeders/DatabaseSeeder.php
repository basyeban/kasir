<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin POS',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Kasir User
        User::factory()->create([
            'name' => 'Kasir POS',
            'email' => 'kasir@example.com',
            'password' => bcrypt('password'),
            'role' => 'kasir',
        ]);

        // Categories
        $cat1 = Category::create(['name' => 'Makanan', 'slug' => 'makanan']);
        $cat2 = Category::create(['name' => 'Minuman', 'slug' => 'minuman']);

        // Products
        Product::create([
            'category_id' => $cat1->id,
            'name' => 'Nasi Goreng',
            'price' => 15000,
            'stock' => 10,
        ]);

        Product::create([
            'category_id' => $cat1->id,
            'name' => 'Mie Ayam',
            'price' => 12000,
            'stock' => 8,
        ]);

        Product::create([
            'category_id' => $cat2->id,
            'name' => 'Es Teh Manis',
            'price' => 5000,
            'stock' => 20,
        ]);
    }
}
