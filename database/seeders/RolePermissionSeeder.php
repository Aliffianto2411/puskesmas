<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat role jika belum ada
        $roleNames = [
            Role::ROLE['ADMIN'],
            Role::ROLE['USER'],
            Role::ROLE['DOKTER'],
        ];
        $this->seedRoles($roleNames);

        // 2. Seed permission hanya untuk tabel janji_temu
    foreach (['janji_temu', 'poli', 'detail_keluarga', 'users', 'roles', 'permissions', 'jadwal_dokter', 'keluarga', 'pengumuman'] as $table) {
        $this->seedPermissions($table);
    }

        // 3. Ambil role dari database
        $admin = Role::where('name', Role::ROLE['ADMIN'])->first();
        $user = Role::where('name', Role::ROLE['USER'])->first();
        $dokter = Role::where('name', Role::ROLE['DOKTER'])->first();

        // 4. Assign full permission ke admin
        $this->assignPermissionsToRole($admin, [
            'viewAny' => ['janji_temu', 'poli', 'detail_keluarga', 'users', 'roles', 'permissions', 'jadwal_dokter','keluarga','pengumuman'],
            'view' => ['janji_temu', 'poli', 'detail_keluarga', 'users', 'roles', 'permissions', 'jadwal_dokter','keluarga','pengumuman'],
            'create' => ['janji_temu', 'poli', 'detail_keluarga', 'users', 'roles', 'permissions', 'jadwal_dokter','keluarga','pengumuman'],
            'update' => ['janji_temu', 'poli', 'detail_keluarga', 'users', 'roles', 'permissions', 'jadwal_dokter','keluarga','pengumuman'],
            'delete' => ['janji_temu', 'poli', 'detail_keluarga', 'users', 'roles', 'permissions', 'jadwal_dokter','keluarga','pengumuman'],
            'restore' => ['janji_temu', 'poli', 'detail_keluarga', 'users', 'roles', 'permissions', 'jadwal_dokter','keluarga','pengumuman'],
            'forceDelete' => ['janji_temu', 'poli', 'detail_keluarga', 'users', 'roles', 'permissions', 'jadwal_dokter','keluarga','pengumuman'],
        ]);

        // 5. Assign permission terbatas ke user
        $this->assignPermissionsToRole($user, [
            'viewAny' => ['janji_temu'],
            'view' => ['janji_temu'],
        ]);

        // 6. Assign permission terbatas ke dokter
        $this->assignPermissionsToRole($dokter, [
            'viewAny' => ['janji_temu', 'jadwal_dokter', 'keluarga'],
            'view' => ['janji_temu', 'jadwal_dokter', 'keluarga'],
            'create' => ['janji_temu', 'jadwal_dokter', 'keluarga'],
            'update' => ['janji_temu', 'jadwal_dokter', 'keluarga'],
        ]);
    }

   public function seedPermissions(string ...$tableNames): void
{
    $permissions = [
        'viewAny',
        'view',
        'create',
        'update',
        'delete',
        'restore',
        'forceDelete',
    ];

    foreach ($tableNames as $tableName) {
        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                'name' => $permission . '.' . $tableName,
            ]);
        }
    }
}

    public function seedRoles(array $roleNames): void
    {
        foreach ($roleNames as $roleName) {
            Role::updateOrCreate([
                'name' => $roleName,
            ]);
        }
    }

    public function assignPermissionsToRole(Role $role, array $permissions): void
    {
        foreach ($permissions as $permission => $tables) {
            $rolePermissions = Permission::whereIn(
                'name',
                array_map(fn($table) => $permission . '.' . $table, $tables)
            )->get();

            $role->permissions()->syncWithoutDetaching($rolePermissions);
        }
    }
}