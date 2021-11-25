<?php

namespace Database\Seeders;

use App\Repositories\UserRepository;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function run(UserRepository $repository)
    {
        $hasher = app(Hasher::class);

        $users = collect([
            'admin' =>      ['email' => 'admin@gmail.com', 'first_name' => 'Админ', 'password' => $hasher->make('12345678')],
            'manager' =>    ['email' => 'manager@gmail.com', 'first_name' => 'Менеджер', 'password' => $hasher->make('12345678')],
            'user' =>       ['email' => 'user@gmail.com', 'first_name' => 'Пользователь', 'password' => $hasher->make('12345678')],
        ]);

        $users->each(function ($item, $role) use ($repository) {
            $repository->updateOrCreate(
                ['email' => $item['email']],
                ['first_name' => $item['first_name'], 'password' => $item['password']],
                $role
            );
        });
    }
}
