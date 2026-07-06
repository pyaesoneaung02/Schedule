<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    User::create([
        'name' => 'Super Admin Account',
        'email' => 'superadmin@gmail.com',
        'password' => Hash::make('Admin@123'),
        'role' => 'superadmin',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    }
}
