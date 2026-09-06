<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // 1. Buat Roles
        $roles = ['admin', 'guru', 'siswa'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // 2. Buat User Admin[cite: 1]
        User::create([
            'name' => 'Admin TU',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'),
            'role_id' => 1, // Admin
        ]);

        // 3. Buat User Guru & Siswa[cite: 1]
        User::create([
            'name' => 'Budi Guru',
            'email' => 'guru@sekolah.com',
            'password' => Hash::make('password'),
            'role_id' => 2, // Guru
        ]);

        User::create([
            'name' => 'Andi Siswa',
            'email' => 'siswa@sekolah.com',
            'password' => Hash::make('password'),
            'role_id' => 3, // Siswa
        ]);
    }
}
