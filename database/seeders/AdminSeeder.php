<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => bcrypt('admin123'), 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

// salin http:127.0.0.1:8000 (ctrl + c)
// lalu buka di chrome atau web browser apapun

// akun admin
// email: admin@admin.com
// password: admin123


// akun customer
// email: customer@example.com
// password: 12345678