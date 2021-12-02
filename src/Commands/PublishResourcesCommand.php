<?php

namespace Future\LaraAdmin\Commands;

use Illuminate\Console\Command;

class PublishResourcesCommand extends Command
{
	protected $signature = 'future:publish';

	protected $description = 'Публикация blade шаблонов Future';

	public function handle(): void
	{
		$choices = $this->asking();

		collect($choices)->each(function ($tag) {
			if ($tag === 'none') {
				return;
			}
			$this->call('vendor:publish', ['--provider' => 'Future\LaraAdmin\LaraAdminServiceProvider', '--tag' => $tag]);
		});
	}

	protected function asking(): array
	{
		return $this->choice(
			'Выберите из списка один или несколько шаблонов, которые хотите опубликовать. (Пример: 1 или 1,2,3):',
			[
				'future::views.all',
				'future::views.layouts',
				'future::views.components',
				'future::views.pages.admin',
				'future::views.pages.admin.index',
				'future::views.pages.admin.auth',
				'future::views.pages.admin.permissions',
				'future::views.pages.admin.roles',
				'future::views.pages.admin.users',
				'none',
			],
			null,
			null,
			true
		);
	}
}