<?php

namespace Oka6\Admin;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Oka6\Admin\Console\Commands\RefreshRoutes;
use Oka6\Admin\Library\SessionManager;
use Oka6\Admin\Models\Profile;
use Oka6\Admin\Models\Resource;
use Oka6\Admin\Models\User;


class Oka6ServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		
		$this->loadTranslationsFrom(__DIR__ . '/Resources/lang', 'admin');
		$this->loadViewsFrom(__DIR__ . '/Resources/views', 'Admin');
		$this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
		$this->loadRoutesFrom(__DIR__ . '/Http/Routes/web.php');
		
		$this->publishes([
			__DIR__ . '/Resources/lang' => resource_path('lang'),
		]);

		$this->publishes([
			__DIR__ . '/../vendor' => public_path('vendor'),
		], 'public');
		

		$this->mergeConfigFrom(
			__DIR__ . '/Config/admin.php', 'admin'
		);
        $this->mergeConfigFrom(
			__DIR__ . '/Config/profile_type.php', 'admin.profile_type'
		);

        $this->mergeConfigFrom(
            __DIR__ . '/../mix-manifest.json', 'app.merge-mix-admin'
        );

		$this->mergeConfigFrom(
			__DIR__ . '/Config/database.php', 'database.connections'
		);
		
		$this->mergeConfigFrom(
			__DIR__ . '/Config/auth_providers.php', 'auth.providers'
		);
		
		$this->mergeConfigFrom(
			__DIR__ . '/Config/providers.php', 'app.providers'
		);
		
		$this->mergeConfigFrom(
			__DIR__ . '/Config/datatables.php', 'app.datatables'
		);
		
		$this->mergeConfigFrom(
			__DIR__ . '/Config/session.php', 'session'
		);
		
		
		$this->mergeViewComposer();
		
		if (php_sapi_name() != 'cli') {
			$this->setObservers();
		}
		
	}
	
	protected function setObservers() {
		
		Profile::observe("Oka6\\Admin\\Observers\\ProfileObserver");
		Resource::observe("Oka6\\Admin\\Observers\\ResourcesObserver");
		User::observe("Oka6\\Admin\\Observers\\UserAdminObserver");
		
		Event::listen('log.createdRequest', function ($obj) {
			
			$data = json_encode($obj->request, true);
			
			$log_ = "Creating {$obj->model->getTable()} RequestData {$data} register #{$obj->model->id} for User {$obj->auth->id}#{$obj->auth->name}";
			
			Log::info($log_);
			
		});
		
		Event::listen('log.updatedRequest', function ($obj) {
			
			$data = json_encode($obj->request, true);
			
			$log_ = "Updating {$obj->model->getTable()} RequestData {$data} register #{$obj->model->id} for User {$obj->auth->id}#{$obj->auth->name}";
			
			Log::info($log_);
			
		});
		
		App::setLocale('pt-BR');
		
		
	}
	
	/**
	 * Merge the given configuration with the existing configuration.
	 *
	 * @param string $path
	 * @param string $key
	 * @return void
	 */
	protected function mergeConfigFrom($path, $key) {
		
		$config = $this->app['config']->get($key, []);

		if ($key == 'admin' && !isset($config['prefix_url'])) {
			$this->app['config']->set($key, array_merge($config, require $path));
		}

		if ($key == 'database.connections' && !isset($config['oka6_admin_session'])) {
			$this->app['config']->set($key, array_merge($config, require $path));
		}

        if ($key == 'admin.profile_type') {
            $this->app['config']->set($key, array_merge($config, require $path));
        }

		if ($key == 'auth.providers') {
			$this->app['config']->set($key, array_merge($config, require $path));
		}
		
		if ($key == 'app.providers') {
			$this->app['config']->set($key, array_merge($config, require $path));
		}
		
		if ($key == 'app.datatables') {
			$this->app['config']->set($key, array_merge($config, require $path));
		}
		
		if ($key == 'session') {
			$this->app['config']->set($key, array_merge($config, require $path));
		}
		
		if ($key == 'admin.profile_type') {
			$this->app['config']->set($key, array_merge($config, require $path));
		}
		
		if ($key == 'app.merge-mix-admin' && empty($config)) {
			try {
				$jsonMixProject = json_decode(file_get_contents(public_path('/mix-manifest.json')), true);
			} catch (\Exception $e) {
				$jsonMixProject = [];
			}
			
			$jsonMix = json_decode(file_get_contents($path), true);
			$jsonMerge = array_merge(is_array($jsonMixProject) ? $jsonMixProject : [], $jsonMix);
			$file = fopen(public_path('/mix-manifest.json'), 'w');
			fwrite($file, json_encode($jsonMerge, JSON_UNESCAPED_SLASHES));
			fclose($file);
			$this->app['config']->set($key, true);
		}
		
		
	}
	
	
	/**
	 * Merge View Navigation Composer
	 *
	 * @return void
	 */
	protected function mergeViewComposer() {
		
		view()->composer('*', \Oka6\Admin\Http\ViewComposers\NavigationComposer::class);
	}
	
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		/** Ajusta a sessao para salvar no mongo */
		$this->app->resolving('session', function ($session) {
			$session->extend('mongodb', function ($app) {
				$manager = new SessionManager($app);
				return $manager->driver('mongodb');
			});
		});
		
		$this->commands([
			RefreshRoutes::class
		]);
		
		
		$this->app->bind(
			\Illuminate\Contracts\Debug\ExceptionHandler::class,
			'Oka6\Admin\Oka6Handler'
		);
	}
}
