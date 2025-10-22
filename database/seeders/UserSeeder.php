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
        User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
            ]
        );

        User::create(
            [
                'name' => 'Kasir',
                'email' => 'kasir@kasir.com',
                'password' => Hash::make('12345678'),
            ]
        );

        User::create(
            [
                'name' => 'Manajemen',
                'email' => 'manajemen@manajemen.com',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
