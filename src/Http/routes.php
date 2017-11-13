<?php
Route::group(['namespace'=>'Elsayednofal\EasyCrud\Http\Controllers'],function(){
    
    Route::get('easy-crud','EasyCrudController@index');
    Route::any('easy-crud/table-fileds ','EasyCrudController@getTableColumnsData');
    Route::any('easy-crud/check-model/{table_name}','EasyCrudController@checkModel');
    Route::any('easy-crud/save','EasyCrudController@save');
    Route::any('easy-crud/generate','EasyCrudController@generateFiles');
    Route::any('easy-crud/re-genrate-model/{table_name}','EasyCrudController@reGenrateModel');
    Route::get('easy-crud/old','EasyCrudController@old');
    Route::get('easy-crud/delete/{id}','EasyCrudController@delete');
    Route::get('easy-crud/test','EasyCrudController@test');
});