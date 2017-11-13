<?php

namespace Elsayednofal\EasyCrud\Http\Helpers;

use DB;
use Schema;

/**
 * 
 */
class DataBase {

    function getTables() {
        $tables = [];
        $database = \Config::get('database.connections.mysql.database');
        foreach (DB::select('show tables') as $table) {
            $attr = 'Tables_in_' . $database;
            $tables[] = $table->$attr;
        }
        return $tables;
    }

    function getColumns($table) {
        $table_info_columns = DB::select('SHOW COLUMNS FROM ' . $table);
        foreach ($table_info_columns as $column) {
            $columns[$column->Field] = $column->Type;
        }
        return $columns;
    }

    function getRelations($table) {
        $database = \Config::get('database.connections.mysql.database');
        $query = "SELECT  table_name,  column_name ,  referenced_table_name,  referenced_column_name 
            FROM INFORMATION_SCHEMA.key_column_usage 
            WHERE referenced_table_schema = '" . $database . "' 
              AND referenced_table_name IS NOT NULL 
              and ( referenced_table_name = '" . $table . "' or table_name='" . $table . "' )
            ORDER BY table_name, column_name ";

        $relations = \DB::select($query);
        return $relations;
    }

    function getRelationByColumns($table) {
        $relations = $this->getRelations($table);
        $result = [];
        foreach ($relations as $relation) {
            $result[$relation->column_name] = [
                'referenced_table_name' => $relation->referenced_table_name,
                'referenced_column_name' => $relation->referenced_column_name
            ];
        }
        return $result;
    }
    
    function getTableColumns($table){
        return (DB::select('SHOW COLUMNS FROM ' . $table));
    }
    
    function getColumnsProperty($table){
        $columns=$this->getTableColumns($table);
        $result=[];
        foreach($columns as $column){
           $result[$column->Field]=$column;
        }
        return $result;
    }
    
    function getPrimaryKey($table){
        $columns=$this->getTableColumns($table);
        foreach($columns as $column){
            if($column->Key=='PRI'){
                return $column->Field;
            }
        }
        return false;
    }
    
}
