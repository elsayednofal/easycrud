
<label class="switch">
    <label><?=$field->name?></label>
    <input type="checkbox" name="<?=$field->crud->name.'['.$field->name.']'?>" value="1" @if(<?= '$' . $field->crud->name . '_obj->' . $field->name . '==1'?>)<?='{{"checked"}}' ?>@endif/>
    <span></span>
</label>
