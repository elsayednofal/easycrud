
Route::group(['namespace' => 'App\Http\Controllers\<?=config('EasyCrud.controllers_directory')?>', <?php if(is_array(config('EasyCrud.middlewares')) && count(config('EasyCrud.middlewares'))>0){ echo '"middleware"=>"'.implode('","', config('EasyCrud.middlewares')).'",'; }?> 'prefix' => '/<?=config('EasyCrud.url_prefix')?>'], function()
{
    Route::any('<?=kebab_case($name)?>/create','<?= ucfirst($name)?>Controller@anyCreate');
    Route::any('<?=kebab_case($name)?>/update/{id}','<?= ucfirst($name)?>Controller@anyUpdate');
    Route::any('<?=kebab_case($name)?>/delete/{id}','<?= ucfirst($name)?>Controller@anyDelete');
    Route::any('<?=kebab_case($name)?>','<?= ucfirst($name)?>Controller@anyIndex');
});
