<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();


        $permissions = [

            // Dashboard
            'dashboard.view',

            // Kamar
            'kamar.view',
            'kamar.create',
            'kamar.edit',
            'kamar.delete',

            // Penghuni
            'penghuni.view',
            'penghuni.create',
            'penghuni.edit',
            'penghuni.delete',

            // Pengaduan
            'pengaduan.view',
            'pengaduan.create',
            'pengaduan.edit',
            'pengaduan.delete',

            // Pembayaran
            'pembayaran.view',
            'pembayaran.create',
            'pembayaran.edit',
            'pembayaran.delete',

            // Profile
            'profile.view',
            'profile.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $ownerRole = Role::firstOrCreate([
            'name' => 'owner',
            'guard_name' => 'web',
        ]);

        $penghuniRole = Role::firstOrCreate([
            'name' => 'penghuni',
            'guard_name' => 'web',
        ]);

        // Admin mendapatkan semua permission
        $adminRole->syncPermissions(Permission::all());

        // Owner hanya bisa melihat
        $ownerRole->syncPermissions([
            'dashboard.view',

            'kamar.view',

            'penghuni.view',

            'pengaduan.view',

            'pembayaran.view',

            'profile.view',
            'profile.edit',
        ]);

        // Penghuni (sementara hanya profile)
        $penghuniRole->syncPermissions([
            'profile.view',
            'profile.edit',
        ]);

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
