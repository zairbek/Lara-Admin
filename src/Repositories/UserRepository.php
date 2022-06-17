<?php

namespace Future\LaraAdmin\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{
    protected function model(): string
    {
        return config('auth.providers.users.model');
    }

	protected function afterMakeBuilder()
	{
		$this->query->with('roles');
	}

    public function createUser(array $values, $role = null)
    {
        DB::beginTransaction();
        try {
            $model = clone $this->model;
            /** @var User $user */
            $user = $model->fill($values);
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

	/**
	 * @param null $field
	 * @param null $search
	 * @return Builder
	 */
	public function search($field = null, $search = null): Builder
	{
		if (! $field && ! $search) {
			return $this->query;
		}

		return match ($field) {
			'id' => $this->query->where('id', $search),
			'name' => $this->query
				->where(DB::raw(
					"LOWER(REPLACE(CONCAT(
                                    COALESCE(first_name,''),' ',
                                    COALESCE(last_name,''),' ',
                                    COALESCE(second_name,'')
                                ),
                            '  ',' '))"
				), 'like', '%' . strtolower($search) . '%'),
			'email' => $this->query->where('email', 'like', "%$search%"),
			'roles' => $this->query->whereHas('roles', function (Builder $builder) use ($search) {
				return $builder->where('title', 'like', "%$search%");
			}),
			default => $this->query,
		};
	}
}
