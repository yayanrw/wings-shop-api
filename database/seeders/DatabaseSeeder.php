<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin Wings Shop',
            'email' => 'admin@wingsshop.com',
            'password' => Hash::make("Bismillah."),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Yayan Rahmat Wijaya',
            'email' => 'yayan@email.com',
            'password' => Hash::make("Bismillah."),
            'role' => 'end_user',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'End User',
            'email' => 'enduser@email.com',
            'password' => Hash::make("Bismillah."),
            'role' => 'end_user',
        ]);
    }
}
