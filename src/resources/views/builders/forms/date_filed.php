<div class="form-group" >
    <label class="control-label"><?=$field->name?></label>
    <input type="date" name="<?=$field->crud->name.'['.$field->name.']'?>" class="form-control" value="<?='{{$'.$field->crud->name.'_obj->'.$field->name.'}}'?>" />
</div>

