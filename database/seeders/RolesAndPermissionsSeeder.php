<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo các quyền
        $create = Permission::create(['name' => 'create']);
        $edit = Permission::create(['name' => 'edit']);
        $delete = Permission::create(['name' => 'delete']);

        // Tạo vai trò
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Gán quyền cho vai trò
        $admin->permissions()->attach([$create->id, $edit->id, $delete->id]);
        $user->permissions()->attach([$create->id, $edit->id]);

        // Gán vai trò cho người dùng
        $adminUser = User::find(1);  // Giả sử ID = 1 là admin

        $adminUser->roles()->attach($admin->id);

    }
}
