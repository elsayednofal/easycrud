<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Elsayednofal\EasyCrud\Models;

/**
 * Description of EasyCrudsFileds
 *
 * @author sayed
 */
class EasyCrudsFileds extends BaseModel {
    protected $table='easy_cruds_fildes';
    protected $guarded = ['id'];
    public $rules=[
        'crud_id'=>'required',
        'name'=>'required',
        'type'=>'required'
    ];
    
    function crud(){
        return $this->belongsTo('Elsayednofal\EasyCrud\Models\EasyCruds', 'crud_id');
    }
    
}
