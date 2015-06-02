<?php namespace Chongkan\MediaManager;

use Chongkan\MediaManager\Controllers\MediasController;
use Chongkan\MediaManager\Facades\MediaManager;
use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */

	protected $defer = false;

    protected $filters = [
        'auth' => 'App\Http\Filters\AuthFilter',
        'auth.basic' => 'App\Http\Filters\BasicAuthFilter',
        'csrf' => 'App\Http\Filters\CsrfFilter',
        'guest' => 'App\Http\Filters\GuestFilter',
        'visitor' => 'Woodmarks\Mila\Http\Filters\VisitorFilter',
    ];

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('chongkan/media-manager');

        // Bring the application container instance into the local scope so we can
        // import it into the filters scope.
        $app = $this->app;

        // Register local Filter handler
        /*\Route::filter('CKPositions', function($route, $request, $response){
            $path = $route->getPath();
            MediasController::render($response, $path);
        }); */

        include __DIR__.'/filters.php';
        // Include package routes file
        include __DIR__.'/routes.php';

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        // Register with the IoC
        $this->app['mediaManager'] = $this->app->share(function($app)
        {
            return new MediaManager();
        });
        // Configure alias
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('MediaManager', 'Chongkan\MediaManager\Facades\MediaManager');
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('mediaManager');
	}

}
