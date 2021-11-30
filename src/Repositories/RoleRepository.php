<?php

namespace Future\LaraAdmin\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository extends Repository
{
    public const DEFAULT_ROLE = 'user';

    protected function model(): string
    {
        return Role::class;
    }

    public function getDefaultRole(): Role
    {
        return $this->model()::findByName(self::DEFAULT_ROLE);
    }
}
