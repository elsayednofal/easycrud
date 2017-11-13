<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elsayednofal\EasyCrud\Http\Builders;

use Elsayednofal\EasyCrud\Models\EasyCruds;
use Elsayednofal\EasyCrud\Models\EasyCrudsFileds;
/**
 * Description of HtmlBuilder
 *
 * @author sayed
 */
class HtmlBuilder extends Builder {
    
    function builtCreate(EasyCruds $crud){
        $view=  view(config("EasyCrud.templates_path").'.builders.html.create',['crud'=>$crud]);
        return $view->render();
    }
    
    function builtUpdate(EasyCruds $crud){
        $view=  view(config("EasyCrud.templates_path").'.builders.html.update',['crud'=>$crud]);
        return $view->render();
    }
    
    function builtIndex(EasyCruds $crud){
        $fields=  EasyCrudsFileds::where('crud_id',$crud->id)->whereIn('name',  explode(',', $crud->index_fildes))->get();
        $view=  view(config("EasyCrud.templates_path").'.builders.html.index',['crud'=>$crud,'fields'=>$fields]);
        return $view->render();
    }
    
    public static function displayField(EasyCrudsFileds $field,$row='$row'){
        switch ($field->form_type) {
            case 'Image Manager':
                return static::displayImage($field,$row);
            case 'Select Box':
                return static::displaySelect($field,$row);
            default:
                return '{{'.$row.'->'.$field->name.'}}';
        }
    }
    
    private static function displayImage(EasyCrudsFileds $field,$row='$row'){
        return '<img src="{{ImageManager::getImagePath('.$row.'->'.$field->name.',"small")}}" style="max-width:100px"/>';
    }
    
    private static function displaySelect(EasyCrudsFileds $field,$row='$row'){
        if($field->is_forgin){
            return '{{'.$row.'->'.str_singular($field->related_table).'->'.$field->related_column.'}}';
        }else{
            return '{{'.$row.'->'.$field->name.'}}';
        }
    }
    
    
    function addToFiles(EasyCruds $crud){
        
        if(!file_exists('./../resources/views/backend/')){
            mkdir('./../resources/views/backend', 0755);
        }
        if(!file_exists('./../resources/views/backend/'.$crud->name)){
            mkdir('./../resources/views/backend/'.$crud->name, 0755);
        }
        
        // build create file
        $html_create= $this->builtCreate($crud);
        file_put_contents('./../resources/views/backend/'.$crud->name.'/create.blade.php', $html_create);
        // build update file
        $html_update= $this->builtUpdate($crud);
        file_put_contents('./../resources/views/backend/'.$crud->name.'/update.blade.php', $html_update);
        // build index file
        $html_index= $this->builtIndex($crud);
        file_put_contents('./../resources/views/backend/'.$crud->name.'/index.blade.php', $html_index);
    }
    
}
