<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = ['manage users', 'edit posts', 'delete posts'];
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);

        $admin->givePermissionTo(Permission::all());
        $editor->givePermissionTo(['edit posts']);

        // Assign role to an existing user
        $user = User::where('email', 'test@example.com')->first(); // replace with actual email
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
