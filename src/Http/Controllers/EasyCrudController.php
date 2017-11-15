<?php

namespace Elsayednofal\EasyCrud\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Elsayednofal\EasyCrud\Http\Helpers\DataBase;
use Elsayednofal\EasyCrud\Models\EasyCruds;
use Elsayednofal\EasyCrud\Models\EasyCrudsFileds;
use Illuminate\Support\Facades\DB;
use Elsayednofal\EasyCrud\Http\Builders\ControllersBuilder;
use Elsayednofal\EasyCrud\Http\Builders\HtmlBuilder;
use Elsayednofal\EasyCrud\Http\Builders\FormBuilder;
use Elsayednofal\EasyCrud\Http\Builders\RouteBuilder;
use Elsayednofal\EasyCrud\Http\Helpers\Models;



class EasyCrudController extends Controller {

    function index() {

        return view('EasyCrud::index');
    }

    function getTableColumnsData(Request $request) {
        $response = new \stdClass();
        if (!isset($request->table_name)) {
            $response->status = 'error';
            $response->message = 'Missing table name !';
            $response->data = [];
            return json_encode($response);
        }
        
        if(is_object(EasyCruds::where('name',$request->table_name)->first())){
            $response->status = 'error';
            $response->message = 'crud data already exist ,<br/> if you want to overwrite it go to old cruds and delete old one.';
            $response->data = [];
            return json_encode($response);
        }
        
        $DataBase = new DataBase;
        if(!$DataBase->getPrimaryKey($request->table_name)){
            $response->status = 'error';
            $response->message = 'Table does not valide , no primary key founded';
            $response->data = [];
            return json_encode($response);
        }

        $columns = $DataBase->getColumns($request->table_name);
        $columns_property=$DataBase->getColumnsProperty($request->table_name);
        $relations = $DataBase->getRelationByColumns($request->table_name);
        $data['table_name'] = $request->table_name;
        $data['columns'] = $columns;
        $data['relations'] = $relations;
        $data['columns_property'] = $columns_property;

        $response->status = 'ok';
        $response->message = 'success';
        $response->data = view('EasyCrud::table_columns_data', $data)->render();
        return json_encode($response);
    }

    function test(Request $request) {
        $object=new $request->namespace;
        if(method_exists($object,'validate')){
            echo 'validate exist';
        }
        if(property_exists($object,'rules')){
            echo '<br/> Rules Exist';
        }
        if(property_exists($object,'guarded')){
            echo '<br/> guarded Exist';
        }
        if(property_exists($object,'errors')){
            echo '<br/> errors Exist';
        }
    }
    
    function save(Request $request){
        $response=new \stdClass();
        try{
            DB::beginTransaction();
            
            if(is_object(EasyCruds::where(['name'=>$request->main_table['name']])->first())){
                $error_message='Crud data already exist';
                throw new \Exception('Data already exist');
            }
            
            $crud=new EasyCruds();
            $crud->fill($request->main_table);
            $crud->index_fildes=implode(',', $request->indexs_show);
            if(!$crud->validate()){
                $response->errors=$crud->errors()->all();
                throw new \Exception('Crud Validate Data');
            }
            $crud->save();
            
            $table_name=$crud->name;
            foreach($request->$table_name as $filed=>$data){
                $crud_fileds=new EasyCrudsFileds();
                $crud_fileds->fill($data);
                $crud_fileds->crud_id=$crud->id;
                $crud_fileds->name=$filed;
                
                
                if(!$crud_fileds->validate()){
                    $response->errors=$crud_fileds->errors()->all();
                    throw new \Exception('Crud Fileds Validate Data');
                }
                $crud_fileds->save();
            }
            
             
            $response->status='ok';
            $response->id=$crud->id;
            $response->data='<div class="alert-success alert-dismiss message">Data Saved Successfully</div>';
            DB::commit();
        } catch (\Exception $ex) { 
            //dd($ex);
            $response->status='error';
            if(isset($response->errors))
                $response->data='<div class="alert-danger alert-dismiss message">Please fix errors <br/>'. implode(',', $response->errors).'</div>';
            else if($error_message)
                $response->data='<div class="alert-danger alert-dismiss message">'.$error_message.'</div>';
            else
                $response->data='<div class="alert-danger alert-dismiss message">Something Went Wrong !</div>';
            DB::rollBack();
        }
        return json_encode($response);
    }
    
    function generateFiles(Request $request){
        $response=new \stdClass();
        try{
            $crud= EasyCruds::find($request->id);
            // generate controller file
            $controller_builder=new ControllersBuilder();
            $controller_builder->addToFile($crud);

            // generate html files
            $html_builder=new HtmlBuilder();
            $html_builder->addToFiles($crud);

            //generate form file
            $form_builder=new FormBuilder();
            $form_builder->addToFile($crud);
            
            // generate route
            $route_builder=new RouteBuilder();
            $route_builder->addToFile($crud->model);
            
            $response->status='ok';
            $response->data['url']= url(config('EasyCrud.url_prefix').'/'.kebab_case(ucfirst(camel_case($crud->name))));
            $response->message='<div class="alert-success alert-dismiss message">Files generated successfully</div>';
            $crud->is_genrated=1;
            $crud->save();
        } catch (Exception $ex) {
            $response->status='ok';
            $response->message='<div class="alert-danger alert-dismiss message">something went wrong <br/> try again , if proplem still happen <br/> email me elsayed nofal : elsayed_nofal@ymail.com </div>';
        }
        return json_encode($response);
        
    }
    
    function old(){
        $cruds= EasyCruds::all();
        return view('EasyCrud::old',['cruds'=>$cruds]);
    }
    
    function delete($id){
        EasyCruds::find($id)->delete();
        return 'ok';
    }
    
    function checkModel($table_name){
        //check baseModel
        $base_model_json=$this->getData(url('laracrud/api/check-base-model'));
        $base_model_data= json_decode($base_model_json);
        if(!$base_model_data->exist){
           // dd($base_model_data->exist);
            $this->getData (url('laracrud/api/generate-base-model'));
        }
        
        
        $json=$this->getData(url('laracrud/api/check-model/'.$table_name));
        $models_data= json_decode($json);
        $model_class=new Models();
        $models_data=array_reverse($models_data);
        foreach($models_data as $key=>$row){
            $models_data[$key]->generated=false;
            if(!$row->exist){
                $this->getData(url('laracrud/api/generate?table='.$table_name.'&file='.$row->file),TRUE);
                $models_data[$key]->generated=TRUE;
            }
            $models_data[$key]->namespace= $model_class->getFullNamespace( str_replace('/', '\\',$row->file));
            $models_data[$key]->is_valide=$this->validateModel($models_data[$key]->namespace);
            $models_data[$key]->table_name=$table_name;
        }
        $models_data=array_reverse($models_data);
        echo json_encode($models_data);die();
    }
    
    function getData($url,$post=false) {
	$ch = curl_init();
	$timeout = 5;
        if($post){
            curl_setopt($ch, CURLOPT_POST, 1);
        }
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
    
    function validateModel($namespace){
        try{
            if((new \ReflectionClass($namespace))->isAbstract()){
                return true;
            }

            $object=new $namespace;
            if(    method_exists($object,'validate')
                && property_exists($object,'rules')
                && property_exists($object,'guarded')
                && property_exists($object,'errors')
                && property_exists($object,'rules')
               ){
                return true;
            }
        } catch (\Exception $ex){
            return false;
        }
        return false;
    }
    
    function reGenrateModel($table_name){
        $response=new \stdClass();
        try{
            $json=$this->getData(url('laracrud/api/check-model/'.$table_name));
            $models_data= json_decode($json);
            $model_class=new Models();
            foreach($models_data as $key=>$row){
                $this->getData(url('laracrud/api/generate?table='.$table_name.'&file='.$row->file),TRUE);
                $models_data[$key]->generated=TRUE;
                $models_data[$key]->namespace= $model_class->getFullNamespace( str_replace('/', '\\',$row->file));
                $models_data[$key]->is_valide=$this->validateModel($models_data[$key]->namespace);
                $models_data[$key]->table_name=$table_name;
            }
            $response->status='ok';
            $response->message='models generated successfully';
            $response->data=$models_data;
        } catch (\Exception $ex) {
            $response->status='warning';
            $response->message='something went wrong';
        }
        return json_encode($response);
    }
    
}
