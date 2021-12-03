<?php

namespace Future\LaraAdmin\Database\Seeders;

use Faker\Factory;
use Future\LaraAdmin\Models\User;
use Future\LaraAdmin\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FakeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function run(UserRepository $repository, int $count = 10)
    {
    	$faker = Factory::create();

    	for ($i = 0; $i < $count; $i++) {
    		$repository->createUser([
				'first_name' => $faker->firstName,
				'last_name' => $faker->lastName,
				'second_name' => $faker->name,
				'login' => $faker->userName,
				'phone_number' => null,
				'email' => $faker->unique()->safeEmail(),
				'email_verified_at' => now(),
				'password' => 'password',
				'remember_token' => Str::random(10),
				'active' => $faker->boolean,
				'birthday' => $faker->date,
			]);
		}
    }
}
