<div class="form-group" >
    <label class="control-label"><?=$field->name?></label>
    <input type="datetime" name="<?=$field->crud->name.'['.$field->name.']'?>" step="1" class="form-control" value="<?='{{$'.$field->crud->name.'_obj->'.$field->name.'}}'?>" />
</div>

