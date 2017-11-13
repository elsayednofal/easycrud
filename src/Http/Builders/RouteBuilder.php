<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elsayednofal\EasyCrud\Http\Builders;
use Illuminate\Foundation\Application;

/**
 * Description of RouteBuilder
 *
 * @author Sayed
 */
class RouteBuilder extends Builder {
    
    function built($name){
        $name=  explode('\\', $name);
        $name=  end($name);
        $view=view(config("EasyCrud.templates_path").'.builders.routes.route',['name'=>$name]);
        return $view->render();
    }
    
    function addToFile($name){
        
        $route_content=$this->built($name);
            if(floatval(Application::VERSION) >= 5.3){
                if( strpos(file_get_contents('./../routes/easy-crud-route.php'),$route_content) === false) {
                    file_put_contents('./../routes/easy-crud-route.php',$route_content,FILE_APPEND);
                }
            }else{
                 if( strpos(file_get_contents('./../app/Http/easy-crud-route.php'),$route_content) === false) {
                    file_put_contents('./../app/Http/easy-crud-route.php',$route_content,FILE_APPEND);
                 }
            }
        
    }
    
}
