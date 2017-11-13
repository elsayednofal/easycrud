<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elsayednofal\EasyCrud\Http\Builders;
use Elsayednofal\EasyCrud\Models\EasyCrudsFileds;
use Elsayednofal\EasyCrud\Models\EasyCruds;
use Elsayednofal\EasyCrud\Http\Builders\JsValidatorBuilder;

/**
 * Description of FormBuilder
 *
 * @author sayed
 */
class FormBuilder extends Builder {
  
    function initForm(){
        return '<form method="post" action="" >'."\n";
    }
    
    function closeForm(){
        return '</form>'."\n";
    }
    
    function csrfToken(){
        return '{{ csrf_field() }}'."\n";
    }
    
    function createSubmit(){
        $view=  view(config("EasyCrud.templates_path").'.builders.forms.submit');
        return $view->render();
    }
    
    function createTextField(EasyCrudsFileds $field){
        $view=view(config("EasyCrud.templates_path").'.builders.forms.text_filed',['field'=>$field]);
        return $view->render();
    }
    
    function createNumberFiled(EasyCrudsFileds $field){
        $view=view(config("EasyCrud.templates_path").'.builders.forms.number_filed',['field'=>$field]);
        return $view->render();
    }
    
    function createTextAreaField(EasyCrudsFileds $field){
        $view=view(config("EasyCrud.templates_path").'.builders.forms.text_area_field',['field'=>$field]);
        return $view->render();
    }
    
    function createImageManagerField(EasyCrudsFileds $field){
        $view=view(config("EasyCrud.templates_path").'.builders.forms.image_manager_field',['field'=>$field]);
        return $view->render();
    }
    
    function createCheckBoxField(EasyCrudsFileds $field){
        $view=view(config("EasyCrud.templates_path").'.builders.forms.checkbox_filed',['field'=>$field]);
        return $view->render();
    }
    
    function createSelectBoxField(EasyCrudsFileds $field){
        $view=view(config("EasyCrud.templates_path").'.builders.forms.selectBox_field',['field'=>$field]);
        return $view->render();
    }
    
    function createHiddenField(EasyCrudsFileds $field){
        $view=view(config("EasyCrud.templates_path").'.builders.forms.hidden_field',['field'=>$field]);
        return $view->render();
    }
    
    function createPasswordField(EasyCrudsFileds $field){
        $view=view(config("EasyCrud.templates_path").'.builders.forms.password_filed',['field'=>$field]);
        return $view->render();
    }
    
    function createDateField(EasyCrudsFileds $field){
        $view=view(config("EasyCrud.templates_path").'.builders.forms.date_filed',['field'=>$field]);
        return $view->render();
    }
    
    function buildField(EasyCrudsFileds $field,$target_type=''){
        if($target_type!='')
            $field->form_type=$target_type;
        
        switch ($field->form_type) {
            case 'Text Filed':
                return $this->createTextField($field);
            case 'Number Filed':
                return $this->createNumberFiled($field);
            case 'Text Area':
                return $this->createTextAreaField($field);
            case 'Image Manager':
                return $this->createImageManagerField($field);
            case 'Checkbox':
                return $this->createCheckBoxField($field);
            case 'Select Box':
                return $this->createSelectBoxField($field);
            case 'Hidden value':
                return $this->createHiddenField($field);
        }
    }
    
    function builtFormFile($fields){
        $form=$this->initForm();
        $form.=$this->csrfToken();
        foreach($fields as $field){
            $form.=$this->buildField($field);
        }
        $form.=$this->createSubmit();
        $form.=$this->closeForm();
        return $form;
    }
    
    function addToFile(EasyCruds $crud){
        $form=$this->builtFormFile($crud->fields);
        if(!file_exists('./../resources/views/backend/')){
            mkdir('./../resources/views/backend', 0755);
        }
        if(!file_exists('./../resources/views/backend/'.$crud->name)){
            mkdir('./../resources/views/backend/'.$crud->name, 0755);
        }
        
        $js_validator=new JsValidatorBuilder();
        $model_object= new $crud->model;
        $js_rules=[];
        foreach($crud->fields as $field){
            if(key_exists($field->name, $model_object->rules)){
                $js_rules[$field->name]=$model_object->rules[$field->name];
            }
        }
        $js_validate_content=$js_validator->convertLaravelRulesToJqueryRules($crud->name,$js_rules);
        
        file_put_contents('./../resources/views/backend/'.$crud->name.'/_form.blade.php', $form.'<br/>'.$js_validate_content);
    }
    
    
    
}
