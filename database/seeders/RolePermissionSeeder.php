<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'owner']);
        Role::firstOrCreate(['name' => 'penghuni']);

        // Membuat akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Membuat akun Owner
        $owner = User::firstOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'name' => 'Owner Kost',
                'password' => Hash::make('password'),
            ]
        );
        $owner->assignRole('owner');

        // Membuat akun Penghuni
        $penghuni = User::firstOrCreate(
            ['email' => 'penghuni@gmail.com'],
            [
                'name' => 'Penghuni',
                'password' => Hash::make('password'),
            ]
        );
        $penghuni->assignRole('penghuni');
    }
}
