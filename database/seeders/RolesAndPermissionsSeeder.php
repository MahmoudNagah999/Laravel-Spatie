<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء Permissions
        $editArticles = Permission::create(['name' => 'edit articles']);
        $deleteArticles = Permission::create(['name' => 'delete articles']);
        $viewArticles = Permission::create(['name' => 'view articles']);
        $createArticles = Permission::create(['name' => 'create articles']);

        // إنشاء Roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // إعطاء Permissions للـ Roles
        $adminRole->givePermissionTo($editArticles);
        $adminRole->givePermissionTo($deleteArticles);
        $adminRole->givePermissionTo($viewArticles);
        $adminRole->givePermissionTo($createArticles);

        $userRole->givePermissionTo($viewArticles);
        $userRole->givePermissionTo($createArticles);
    }
}
