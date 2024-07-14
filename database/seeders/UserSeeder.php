<?php

namespace Database\Seeders;

use Carbon\Factory;
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
        \App\Models\User::factory(9)->create();

        \App\Models\User::factory()->create([
            'name' => 'Adil',
            'email' => 'adil@posbojo.com',
            'password' => Hash::make('12345678'),
            'phone' => '087871378500',
            'roles' => 'ADMIN',
        ]);
    }
}
