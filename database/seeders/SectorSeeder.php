<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = ["Pendidikan", "Ekonomi", "Kesehatan", "Militer", "Sipil"];
        foreach ($sectors as $sector) {
            $s = Sector::create([
                "name" => $sector
            ]);
            for ($i = 1; $i <= 5; $i++) {
                $s->contacts()->create([
                    "name" => fake()->name(),
                    "company_name" =>  fake()->company(),
                    "email" => fake()->email(),
                    "phone" => fake()->phoneNumber(),
                    "address" => fake()->address()
                ]);
            }
        }
    }
}
