<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'nathaniel',
            'email' => 'nathaniel@gmail.com',
            'password' => bcrypt('nathaniel'),
        ]);
        User::factory()->create([
            'name' => 'jashreil',
            'email' => 'jashreil@gmail.com',
            'password' => bcrypt('jashreil'),
        ]);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminadmin'),
            'is_admin' => true,
        ]);
    }
}
