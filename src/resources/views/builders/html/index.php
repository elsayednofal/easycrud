<?php echo '@extends(config("EasyCrud.backend_layout"))' . "\n"; ?>

<?php echo '@section("title")' . $crud->name . ' @stop' . "\n"; ?>

<?php echo '@section(config("EasyCrud.layout_content_area"))' . "\n"; ?>

<?= '<?php $'.$crud->name.'_obj=new '.$crud->model.' ?>' ?>

<?= '@if(\Request::has("'.$crud->name.'"))'."\n"?>
    <?= '@foreach(\Request::input("'.$crud->name.'") as $key=>$value)'."\n"?>
        <?= '<?php $'.$crud->name.'_obj->$key=$value?>'."\n"?>
    <?= '@endforeach'."\n"?>
<?= '@endif'."\n"?>

<ol class="breadcrumb">
    <li><a href="javascript:void()">Home</a></li>
    <li><a href="./<?=config('EasyCrud.url_prefix')?>/<?=kebab_case(ucfirst(camel_case($crud->name)))?>" class="active"><?=$crud->name?></a></li>
    <button class="btn btn-lg btn-outline-primary"  title="Create New" style="float:right"><a href="./{{config('EasyCrud.url_prefix')}}/<?=kebab_case(ucfirst(camel_case($crud->name)))?>/create"><span class="glyphicon glyphicon-plus-sign" ></span></a></button>

</ol>

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title"><?=ucfirst($crud->name)?></h3></div>
    <div class="panel-body">

        <div class="row">
            <table class="table table-striped">
                <thead>
                    <form>
                    <tr class="bg-primary">
                        <?php $form_builder=new Elsayednofal\EasyCrud\Http\Builders\FormBuilder();?>
                        <?php foreach ($fields as $field): ?>
                        <?php if($field->form_type=='Image Manager'): ?>
                            <th><?=$field->name?></th>
                        <?php elseif ($field->form_type=='Text Area') : ?>
                            <th><?= $form_builder->buildField($field,'Text Filed') ?></th>
                        <?php else: ?>
                            <th><?= $form_builder->buildField($field) ?></th>
                        <?php endif; ?>
                        <?php endforeach; ?>
                            <th>
                                <button type="submit" name="submit" class="btn btn-primary btn-sm">find</button>
                            </th>
                    </tr>
                    </form>
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
            success
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

