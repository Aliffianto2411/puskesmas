<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Buat roles
        $superAdmin = Role::create(['name' => 'super admin']);
        $dokter = Role::create(['name' => 'dokter']);
        $user = Role::create(['name' => 'user']);

        // Assign role ke user tertentu (misalnya user pertama jadi super admin)
        $adminUser = User::find(1);
        if ($adminUser) {
            $adminUser->assignRole('super admin');
        }
    }
}
