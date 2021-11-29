<?php

namespace Future\LaraAdmin\Database\Seeders;

use Future\LaraAdmin\Repositories\UserRepository;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	public const USERS = [
		'admin' =>      ['email' => 'admin@gmail.com', 'first_name' => 'Админ', 'password' => '12345678'],
		'manager' =>    ['email' => 'manager@gmail.com', 'first_name' => 'Менеджер', 'password' => '12345678'],
		'user' =>       ['email' => 'user@gmail.com', 'first_name' => 'Пользователь', 'password' => '12345678'],
	];

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function run(UserRepository $repository)
    {
        $hasher = app(Hasher::class);

		collect(self::USERS)->each(function ($item, $role) use ($repository, $hasher) {
            $repository->updateOrCreate(
                ['email' => $item['email']],
                ['first_name' => $item['first_name'], 'password' => $hasher->make($item['password'])],
                $role
            );
        });
    }
}
