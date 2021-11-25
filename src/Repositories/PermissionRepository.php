<?php

namespace Future\LaraAdmin\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionRepository extends Repository
{
	/**
	 * @inheritDoc
	 */
	protected function model(): string
	{
		return Permission::class;
	}
}
