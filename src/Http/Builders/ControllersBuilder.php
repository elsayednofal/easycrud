<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elsayednofal\EasyCrud\Http\Builders;
use Elsayednofal\EasyCrud\Models\EasyCruds;
/**
 * Description of ControllersBuilder
 *
 * @author sayed
 */
class ControllersBuilder extends Builder {
    function built(EasyCruds $crud){
        $model_name=  explode('\\', $crud->model);
        $model_name=  end($model_name);
        
        $view=  view(config("EasyCrud.templates_path").'.builders.controller.controller',['crud'=>$crud,'model_name'=>$model_name]);
        return $view->render();
    }
    
    function addToFile(EasyCruds $crud){
        if(!file_exists('./../app/Http/Controllers/'.config('EasyCrud.controllers_directory'))){
            mkdir('./../app/Http/Controllers/'.config('EasyCrud.controllers_directory'), 0755);
        }
        $controller=$this->built($crud);
        file_put_contents('./../app/Http/Controllers/'.config('EasyCrud.controllers_directory').'/'.ucfirst(camel_case($crud->name)).'Controller.php', $controller);
    }
    
    
}
