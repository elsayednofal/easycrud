<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EasyCruds
 *
 * @author sayed
 */
namespace Elsayednofal\EasyCrud\Models;

class EasyCruds extends BaseModel {
    protected $table='easy_cruds';
    protected $guarded=['id'];
    public $rules=[
        'name'=>'required',
        'model'=>'required',
        'type'=>'required'
    ];
    
    function fields(){
        return $this->hasMany('Elsayednofal\EasyCrud\Models\EasyCrudsFileds', 'crud_id')->where('is_active',1);
    }
    
}
