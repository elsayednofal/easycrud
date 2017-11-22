<?php
namespace Elsayednofal\EasyCrud;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
class EasyCrudRouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        
        
        //enject router 
        if(floatval(Application::VERSION) >= 5.3){
            
            $this->loadRoutesFrom(base_path().'/routes/easy-crud-route.php');
        }else{
            include app_path().'/Http/easy-crud-route.php';
        }
        
        
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