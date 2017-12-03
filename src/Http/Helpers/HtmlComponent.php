<?php

namespace Elsayednofal\EasyCrud\Http\Helpers;

use Elsayednofal\EasyCrud\Http\Helpers\DataBase;
use Elsayednofal\EasyCrud\Http\Helpers\Models;

class HtmlComponent {

    static function tablesSelector($name, $config = []) {
        $DataBase = new DataBase;
        $data['tables'] = $DataBase->getTables();
        $data['name']=$name;
        $data['config']=$config;
        return view('EasyCrud::html_components.table_selector',$data)->render();
    }
    
    static function representationSelector($name, $config = []) {
        $data['types']=static::htmlDataTypes();
        $data['name']=$name;
        $data['config']=$config;
        return view('EasyCrud::html_components.representation_selector',$data)->render();
    }

    static function convertSqlDataTypeToFormDataType($sql_type, $name, $relation = false) {
        
        if (in_array($name, ['image', 'image_id', 'photo', 'photo_id'])) {
            return 'Image Manager';
        } else if ($relation) {
            return 'Select Box';
        }else if($name=='password'){
            return 'Password Field';
        }
        switch ($sql_type) {
            case 'varchar':
                return 'Text Filed';
            case strpos( $sql_type, 'int' ):
                return 'Number Filed';
            case strpos( $sql_type, 'tinyint' ):
                return 'Checkbox';
            case strpos( $sql_type, 'enum' ):
                return 'Select Box';
            case 'text':
                return 'Text Area';
            case 'date':
                return 'Date Field';
            case 'timestamp':
                return 'Timestamp';
        }
    }

    static function htmlDataTypes() {
        return ['Text Filed','Date Field','Password Field', 'Number Filed','Timestamp', 'Text Area', 'Image Manager', 'Checkbox', 'Select Box','Hidden value'];
    }

    static function tableColumnsSelestor($name, $config=[]) {
        $DataBase = new DataBase;
        $data['columns'] = $DataBase->getColumns($config['table_name']);
        $data['name']=$name;
        $data['config']=$config;
         return view('EasyCrud::html_components.table_columns_selector',$data)->render();
    }
    
    static function tablesTypes($name,$config=[]){
        $data['types'] = ['Single Table'];
        $data['name']=$name;
        $data['config']=$config;
        return view('EasyCrud::html_components.table_types',$data)->render();
    }
    
    static function modelsSelector($name,$config=[]){
        $data['name']=$name;
        $data['config']=$config;
        $data['models']=(new Models())->getModels();
        return view('EasyCrud::html_components.models_selector',$data)->render();
    }
}
