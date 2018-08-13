@extends({{config("EasyCrud.backend_layout")}})

<?php echo '@section("title")' . $crud->name . ' @stop' . "\n"; ?>

@section({{config("EasyCrud.layout_content_area")}})

<?= '<?php $'.$crud->name.'_obj=new '.$crud->model.' ?>' ?>

<?= '@if(\Request::has("'.$crud->name.'"))'."\n"?>
    <?= '@foreach(\Request::input("'.$crud->name.'") as $key=>$value)'."\n"?>
        <?= '<?php $'.$crud->name.'_obj->$key=$value?>'."\n"?>
    <?= '@endforeach'."\n"?>
<?= '@endif'."\n"?>


<div class="row" style="background-color: #FFFFFF;padding: 0 10px 10px 10px;">
    <h2><?=kebab_case(ucfirst(camel_case($crud->name)))?></h2>
    <ol class="breadcrumb">
        <li><a href="javascript:void()">Home</a></li>
        <li><a href="./<?=config('EasyCrud.url_prefix')?>/<?=kebab_case(ucfirst(camel_case($crud->name)))?>" class="active"><?=$crud->name?></a></li>
        <button class="btn btn-lg btn-outline-primary"  title="Create New" style="float:right"><a href="./{{config('EasyCrud.url_prefix')}}/<?=kebab_case(ucfirst(camel_case($crud->name)))?>/create"><span class="glyphicon glyphicon-plus-sign" ></span></a></button>

    </ol>
</div>

<br style="clear:both">

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title"><?=ucfirst($crud->name)?></h3></div>
    <div class="panel-body">
        <div class="row" style="border-bottom: 1px dashed;margin-bottom: 3px;">
            <form>
                <?php $form_builder=new Elsayednofal\EasyCrud\Http\Builders\FormBuilder();?>
                <?php foreach ($fields as $field): ?>
                <?php if ($field->form_type=='Image Manager') : ?>
                
                <?php elseif ($field->form_type=='Text Area') : ?>
                <div class="col-md-3"><?= $form_builder->buildField($field,'Text Filed') ?></div>
                <?php else: ?>
                    <div class="col-md-2"><?= $form_builder->buildField($field) ?></div>
                <?php endif; ?>
                <?php endforeach; ?>
                    <div class="col-md-2" style="float:right">
                        <br/>
                        <button type="submit" name="submit" class="btn btn-primary">find</button>
                    </div>
            </form>
        </div>

        <br style="clear:both;padding-bottom: 15px">


        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <?php foreach ($fields as $field): ?>
                            <th><?=$field->name?></th>
                        <?php endforeach; ?>
                            <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?= '@foreach($data as $row)'."\n" ?>
                    
                    <tr>
                        <?php foreach ($fields as $field): ?>
                        <td>
                            
                            <?= Elsayednofal\EasyCrud\Http\Builders\HtmlBuilder::displayField($field) ?>
                            
                        </td>
                        
                        <?php endforeach; ?>
                    <td>
                            <a href='./<?=config('EasyCrud.url_prefix')?>/<?=kebab_case(ucfirst(camel_case($crud->name)))?>/delete/{{$row->id}}' class="delete col-md-1"><span class="glyphicon glyphicon-remove"></span></a>
                            <a href='./<?=config('EasyCrud.url_prefix')?>/<?=kebab_case(ucfirst(camel_case($crud->name)))?>/update/{{$row->id}}' class="col-md-1"><span class="glyphicon glyphicon-edit"></span></a>
                    </td>
                    </tr>
                    
                    <?= '@endforeach'."\n" ?>
                    
                </tbody>
            </table>
        </div>
        <div class="row">
            
            <?= '<?=$data->links()?>'."\n" ?>
            
        </div>

    </div>
</div>
<script type='text/javascript'>
$(document).ready(function(){
    $('.delete').click(function(event){
        event.preventDefault();
        if(!confirm('are you sure , you want to delete this row ?')){
            return false;
        }
        button=$(this);
        $.ajax({
            url:$(this).attr('href'),
            success:function(response){
                response=jQuery.parseJSON(response);
                if(response.status==='ok'){
                    button.closest('tr').remove();
                }
                alert(response.message);
            }
        });
        
        
        
    });
});
</script>

<?php echo '@stop'."\n"; ?>

