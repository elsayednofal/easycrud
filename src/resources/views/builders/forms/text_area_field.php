<div class="form-group" >
    <label class="control-label"><?=$field->name?></label>
    <textarea class="form-control" name="<?=$field->crud->name.'['.$field->name.']'?>" ><?='{{$'.$field->crud->name.'_obj->'.$field->name.'}}'?></textarea>
</div>

