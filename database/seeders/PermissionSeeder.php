<?php

namespace Future\LaraAdmin\Database\Seeders;

use Future\LaraAdmin\Repositories\PermissionRepository;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(PermissionRepository $repository)
    {
        $permissions = collect([
            'admin' => [
                ['name' => 'show',      'title' => 'Админ панель']
            ],
            'profile' => [
                ['name' => 'show',      'title' => 'Просмотр'],
                ['name' => 'edit',      'title' => 'Изменение'],
                ['name' => 'delete',    'title' => 'Удаление'],
            ],
            'users' => [
                ['name' => 'show',      'title' => 'Просмотр'],
                ['name' => 'create',    'title' => 'Создание'],
                ['name' => 'edit',      'title' => 'Изменение'],
                ['name' => 'delete',    'title' => 'Удаление'],
            ]
        ]);

        $permissions->each(function ($item, $key) use ($repository) {
            foreach ($item as $permission) {
                $name = $key . '@' . $permission['name'];
                $repository->updateOrCreate(
                    ['name' => $name],
                    ['title' => $permission['title']]
                );
            }
        });
    }
}
