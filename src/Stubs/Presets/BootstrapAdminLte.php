<?php

namespace Future\LaraAdmin\Stubs\Presets;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BootstrapAdminLte extends Preset
{
	public static function install(Command $command): void
	{
		static::updatePackages();
		static::updateWebpackConfiguration();
		static::updateSass();
		static::updateBootstrapping();
		static::removeNodeModules();
		static::publicImages($command);
	}

	/**
	 * Update the given package array.
	 *
	 * @param array $packages
	 * @return array
	 */
	protected static function updatePackageArray(array $packages): array
	{
		return [
				"@fortawesome/fontawesome-free" => "^5.15.4",
				"admin-lte" => "^3.1.0",
				'bootstrap' => '^4.6.0',
				'jquery' => '^3.6',
				'popper.js' => '^1.16.1',
				"overlayscrollbars" => "^1.13.1",
				'sass' => '^1.32.11',
				'sass-loader' => '^11.0.1',
				"resolve-url-loader" => "^4.0.0",
			] + $packages;
	}

	/**
	 * Update the Webpack configuration.
	 *
	 * @return void
	 */
	protected static function updateWebpackConfiguration(): void
	{
		copy(__DIR__ . '/bootstrap-adminlte-stubs/webpack.mix.js', base_path('webpack.mix.js'));
	}

	/**
	 * Update the Sass files for the application.
	 *
	 * @return void
	 */
	protected static function updateSass(): void
	{
		(new Filesystem)->ensureDirectoryExists(resource_path('sass'));

		copy(__DIR__ . '/bootstrap-adminlte-stubs/_variables.scss', resource_path('sass/_variables.scss'));
		copy(__DIR__ . '/bootstrap-adminlte-stubs/app.scss', resource_path('sass/app.scss'));
	}

	/**
	 * Update the bootstrapping files.
	 *
	 * @return void
	 */
	protected static function updateBootstrapping(): void
	{
		(new Filesystem)->ensureDirectoryExists(resource_path('js/scripts'));

		copy(__DIR__ . '/bootstrap-adminlte-stubs/bootstrap.js', resource_path('js/bootstrap.js'));
		copy(__DIR__ . '/bootstrap-adminlte-stubs/scripts/confirm.js', resource_path('js/scripts/confirm.js'));
	}


	protected static function publicImages(Command $command): void
	{
		$imgDir = resource_path('img');

		if (
			file_exists($imgDir)
			&& $command->confirm("Папка [{$imgDir}] уже существует. Вы хотите заменить это?")
		) {
			rmdir($imgDir);
		}

		(new Filesystem())->copyDirectory(__DIR__.'/bootstrap-adminlte-stubs/img', resource_path('img'));
	}
}