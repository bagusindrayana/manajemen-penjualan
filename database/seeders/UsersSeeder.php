<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>"Admin",
            'email'=>'admin@admin.com',
            'password'=>bcrypt('admin4321'),
            'role'=>'admin'
        ]);

        User::create([
            'name'=>"Karyawan",
            'email'=>'karyawan@email.com',
            'password'=>bcrypt('karyawan4321'),
            'role'=>'karyawan'
        ]);
    }
}
