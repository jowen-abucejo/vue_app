<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Carbon\Carbon;
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
        $admin = User::create([
            'name' => 'Juan de la Cruz',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('admin'),
            'user_type' => 'admin',
        ]);

        $this->call([
            EmployeeSeeder::class,
        ]);
    }
}
