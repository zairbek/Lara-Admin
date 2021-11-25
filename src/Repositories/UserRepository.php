<?php

namespace Future\LaraAdmin\Repositories;

use Future\LaraAdmin\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{
    protected function model(): string
    {
        return User::class;
    }

    public function createUser(array $values, $role = null)
    {
        DB::beginTransaction();
        try {
            /** @var User $user */
            $user = $this->model->fill($values);
            $user->save();
            $user = $user->refresh();

            if (is_null($role)) {
                $role = RoleRepository::DEFAULT_ROLE;
            }

            $user->assignRole($role);

            DB::commit();

            return $user;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function updateOrCreate($attributes, $value = [], $role = null): Model
    {
        /** @var User $user */
        $user = parent::updateOrCreate($attributes, $value);

        if (is_null($role)) {
            $role = RoleRepository::DEFAULT_ROLE;
        }
        $user->assignRole($role);

        return $user;
    }

}
