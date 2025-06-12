<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            (object)[
                "name" => "NFC Card",
                "price" => 12000,
            ],
            (object)[
                "name" => "NFC Reader",
                "price" => 1000000,
            ],
            (object)[
                "name" => "ID Card",
                "price" => 15000,
            ],
            (object)[
                "name" => "NFC Tag",
                "price" => 200000,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                "name" => $product->name,
                "price" => $product->price,
                "description" => fake()->paragraph()
            ]);
        }
    }
}
