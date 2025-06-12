<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            (object)[
                "name" => "Admin CRM Tappp",
                "email" => "admin.crm@tappp.link",
                "role" => "admin"
            ],
            (object)[
                "name" => "Sales CRM Tappp",
                "email" => "sales.crm@tappp.link",
                "role" => "sales"
            ],
            (object)[
                "name" => "Yess Admin CRM Tappp",
                "email" => "yesi.crm@tappp.link",
                "role" => "admin"
            ],
        ];

        foreach ($users as $user) {
            User::create([
                "name" => $user->name,
                "email" => $user->email,
                "password" => Hash::make("password"),
                "role" => $user->role
            ]);
        }
    }
}
