<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'linoHH',
            'email' => 'lino@lino',
            'password' => Hash::make('linoalex'), // Usar Hash::make para encriptar la contraseña
        ]);
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // \App\Models\Category::factory(5)->create();
        // \App\Models\Client::factory(20)->create();
        // \App\Models\Brand::factory(5)->create();
        // \App\Models\Product::factory(20)->create();


    }
}
