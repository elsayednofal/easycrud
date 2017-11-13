

<?= '<?php' ?>

namespace App\Http\Controllers\<?=config('EasyCrud.controllers_directory')?>;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use {{$crud->model}};
use DB;

class {{ucfirst(camel_case($crud->name))}}Controller extends Controller
{
    function anyIndex(Request $request){
        $object= new {{$model_name}};
        if($request->has('submit')){
            foreach($request->{{lcfirst($crud->name)}} as $key=>$value){
                if(is_numeric($value)){
                    $object=$object->where($key,$value);
                }else{
                    $object=$object->where($key,'like',$value.'%');
                }
            }
        }
        $data['data']=$object->paginate(15);
        return view('{{config('EasyCrud.controllers_directory')}}.{{lcfirst($crud->name)}}.index',$data);
    }
    
    function anyCreate(Request $request){
        $data=[];
        $data['{{lcfirst($crud->name)}}_obj']=new {{$model_name}}();
        if($request->method()=='POST'){
            $data['{{lcfirst($crud->name)}}_obj']=$this->store(new {{$model_name}}(),$request);
        }
        return view('{{config('EasyCrud.controllers_directory')}}.{{lcfirst($crud->name)}}.create',$data);
    }
    
    function anyUpdate(Request $request,$id){
        ${{lcfirst($crud->name)}}=  {{$model_name}}::find($id);
        if(!${{lcfirst($crud->name)}})abort (404);
        $data['{{lcfirst($crud->name)}}_obj']=${{lcfirst($model_name)}};
        if($request->method()=='POST'){
            $data['{{lcfirst($crud->name)}}_obj']=$this->store(${{lcfirst($crud->name)}},$request);
        }
        return view('{{config('EasyCrud.controllers_directory')}}.{{lcfirst($crud->name)}}.update',$data);
    }
    
    function anyDelete($id){
        ${{lcfirst($crud->name)}}=  {{ucfirst($model_name)}}::find($id);
        $response=new \stdClass();
        if(!${{lcfirst($crud->name)}}){
            $response->status='warning';
            $response->message='raw not found';
        }else{
            ${{lcfirst($crud->name)}}->delete();
            $response->status='ok';
            $response->message='Delete Successfully';
        }
        return json_encode($response);
    }
    
    function store({{ucfirst($model_name)}} ${{lcfirst($crud->name)}},Request $request){
        DB::beginTransaction(); 
        try{
            ${{lcfirst($crud->name)}}->fill($this->resolveImageArrayRequest($request->{{lcfirst($crud->name)}}));
            if(!${{lcfirst($crud->name)}}->validate()){
                Session::flash('validate_errrors',  implode('<br/>', ${{lcfirst($crud->name)}}->errors()->all()));
            }
            ${{lcfirst($crud->name)}}->save();
            
            DB::commit();
            Session::flash('success', 'Saved successfully.');
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return ${{lcfirst($crud->name)}};
    }
    
    function resolveImageArrayRequest($request){
        $result=[];
        foreach($request as $key=>$value){
            if(is_array($value)){
                $result[$key]=$value[0];
            }else{
                $result[$key]=$value;
            }
        }
        return $result;
    }
    
}


