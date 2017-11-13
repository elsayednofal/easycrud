<?php
namespace Elsayednofal\EasyCrud;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
class EasyCrudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/assets' => public_path('vendor/elsayednofal/easycrud'),
                ], 'public');
        $this->publishes([
            __DIR__ . '/config' => config_path(''),
                ]);
        $this->publishes([
        __DIR__.'/resources/views/builders' => resource_path('Views/easy-crud/builders'),
    ]);
        
        //load migrations
        if(floatval(Application::VERSION) >= 5.3){
            $this->loadMigrationsFrom(__DIR__.'/migrations');
        }else{
            $this->publishes([
            __DIR__ . '/migrations' => database_path('migrations'),
                ]);
        }
        
        // load view
        $this->loadViewsFrom(realpath(__DIR__ . '/resources/views'), 'EasyCrud');
        
        //enject router 
        if(floatval(Application::VERSION) >= 5.3){
            $this->publishes([
            __DIR__ . '/routes' => ('routes'),
                ]);
            $this->loadRoutesFrom(base_path().'/routes/easy-crud-route.php');
        }else{
            $this->publishes([
            __DIR__ . '/routes' => ('app/Http'),
                ]);
            $this->loadRoutesFrom(app_path().'/Http/easy-crud-route.php');
        }
        
        
        
        /*
         * loading routes and sometimes add middelware group
         */
        $router=$this->app->router;
        if(config('ImageManager.middelware_group')!=''):
            $router->group([ 'middleware' => [config('EasyCrud.middelware_group')]], function($router) {
			require __DIR__ . '/Http/routes.php';
		});
        else:    
            include __DIR__.'/Http/routes.php';
        endif;   
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