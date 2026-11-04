<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Daftar permission yang dipakai aplikasi.
     *
     * @var list<string>
     */
    public const PERMISSIONS = [
        'view-books',
        'create-books',
        'edit-books',
        'delete-books',
        'manage-categories',
        'manage-users',
    ];

    /**
     * Permission untuk tiap role, mengikuti matriks hak akses pada lembar tugas.
     *
     * @var array<string, list<string>>
     */
    public const ROLE_PERMISSIONS = [
        'Admin' => self::PERMISSIONS,
        'Dosen' => ['view-books', 'create-books', 'edit-books'],
        'Mahasiswa' => ['view-books'],
    ];

    /**
     * Akun pengujian untuk ketiga role.
     *
     * @var list<array{name: string, email: string, role: string}>
     */
    public const ACCOUNTS = [
        ['name' => 'Administrator', 'email' => 'admin@inventaris.test', 'role' => 'Admin'],
        ['name' => 'Dosen Pengampu', 'email' => 'dosen@inventaris.test', 'role' => 'Dosen'],
        ['name' => 'Mahasiswa Contoh', 'email' => 'mahasiswa@inventaris.test', 'role' => 'Mahasiswa'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan cache permission agar perubahan seeder langsung terbaca.
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (self::PERMISSIONS as $permission) {
            Permission::findOrCreate($permission);
        }

        foreach (self::ROLE_PERMISSIONS as $roleName => $permissions) {
            Role::findOrCreate($roleName)->syncPermissions($permissions);
        }

        foreach (self::ACCOUNTS as $account) {
            $user = User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => Hash::make('password'),
                ]
            );

            // syncRoles agar role lama tidak menumpuk saat seeder dijalankan ulang.
            $user->syncRoles([$account['role']]);
        }
    }
}
