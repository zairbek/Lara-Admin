<?php

namespace Database\Seeders;

use Future\LaraAdmin\Repositories\PermissionRepository;
use Future\LaraAdmin\Repositories\RoleRepository;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class GivePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        /** @var Role $admin */
        $admin = $roleRepository->findByField('name', 'admin')->first();
        $permissions = $permissionRepository->all();
        $admin->givePermissionTo($permissions);
    }
}
