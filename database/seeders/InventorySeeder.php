<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@inventaris.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('Admin12345!'),
            ]
        );

        $komputer = Category::firstOrCreate(
            ['name' => 'Komputer'],
            ['description' => 'Perangkat komputer']
        );

        $aksesoris = Category::firstOrCreate(
            ['name' => 'Aksesoris'],
            ['description' => 'Aksesoris komputer']
        );

        $jaringan = Category::firstOrCreate(
            ['name' => 'Jaringan'],
            ['description' => 'Peralatan jaringan']
        );

        $items = [
            ['category_id' => $komputer->id, 'name' => 'Laptop', 'code' => 'INV001', 'quantity' => 5, 'price' => 7500000],
            ['category_id' => $komputer->id, 'name' => 'Monitor', 'code' => 'INV002', 'quantity' => 8, 'price' => 1500000],
            ['category_id' => $aksesoris->id, 'name' => 'Keyboard', 'code' => 'INV003', 'quantity' => 10, 'price' => 250000],
            ['category_id' => $aksesoris->id, 'name' => 'Mouse', 'code' => 'INV004', 'quantity' => 12, 'price' => 100000],
            ['category_id' => $jaringan->id, 'name' => 'Router', 'code' => 'INV005', 'quantity' => 3, 'price' => 650000],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(['code' => $item['code']], $item);
        }
    }
}
