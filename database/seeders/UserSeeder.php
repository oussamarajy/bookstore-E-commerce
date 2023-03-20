<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nom' => 'Admin Admin',
            'email' => 'admin@admin.com',
            'phone' => '+21260000000',
            'isAdmin' => 1,
            'password' => Hash::make(12345678)
        ]);

        User::create([
            'nom' => 'User User',
            'email' => 'user@user.com',
            'phone' => '+21260000000',
            'isAdmin' => 0,
            'password' => Hash::make(12345678)
        ]);
    }
}
