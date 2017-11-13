<div class="form-group">
    <label class="control-label"><?=$field->name?></label><span> click below to choose</span>
    <br/>
    <?php echo '{!! ImageManager::selector("' . $field->crud->name.'['.$field->name.']' . '",[$' . $field->crud->name . '_obj->' . $field->name . '],false) !!}' ?>
</div>

