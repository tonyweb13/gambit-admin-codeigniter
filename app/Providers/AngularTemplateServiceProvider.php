<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class AngularTemplateServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @param Router $router
	 */
	public function boot(Router $router)
	{
		$router->get('ng-templates/{templatePath?}', function ($templatePath=[]) {

			$bladePath = 'ng-templates.' . str_replace('/', '.', $templatePath);

			if (view()->exists( $bladePath )) {
				return view($bladePath);
			}

			return view('errors.404');

		})->where('templatePath', '([A-z\d-\/_.]+)?');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}