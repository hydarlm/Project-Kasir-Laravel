<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@example.com',
            'password' => Hash::make('rahasia123'),
        ]);
    }
}
