<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
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
        User::create([
            'username' => 'seller',
            'nama_lengkap' => 'sellerpenjual',
            'email' => 'seller@gmail.com',
            'nomor_telepon' => '081412112112524',
            'role_id' => '1',
            'alamat' => 'Karanganyar',
            'password' => Hash::make('seller12'),
        ]);

        User::create([
            'username' => 'buyer',
            'nama_lengkap' => 'buyerpembeli',
            'email' => 'buyer@gmail.com',
            'nomor_telepon' => '08961212121',
            'role_id' => '2',
            'alamat' => 'Karanganyar',
            'password' => Hash::make('buyer12'),
        ]);
    }
}
