<?php
echo '<?php ' . "\n";
if ($field->is_forgin == 1) {

    echo '$select_array=[];' . "\n";
    echo '$select_data=DB::table("' . $field->related_table . '")->get();' . "\n";
    echo 'foreach($select_data as $row){' . "\n";
    echo '$select_array[$row->' . $field->related_column . ']=$row->' . $field->referance_column . ';' . "\n";
    echo '}' . "\n";
} else {
    echo '$select_array=["' . str_replace(';', '","', $field->static_value) . '"];' . "\n";
}
echo " ?>\n";
?>
<div class="form-group" >
    <label class="control-label"><?=$field->name?></label>
    <select name="<?=$field->crud->name.'['.$field->name.']'?>" class="form-control">
        <option value="">please choose <?=$field->name?></option>
        <?php
        echo '@foreach($select_array as $key=>$value)?>' . "\n";
        if ($field->is_forgin == 1) {
            echo '<option value="{{$value}}" @if($value==$'.$field->crud->name.'_obj->'.$field->name.')selected @endif>{{$key}}</option>' . "\n";
        } else {
            echo '<option value="{{$value}}" @if($value==$'.$field->crud->name.'_obj->'.$field->name.')selected @endif>{{$value}}</option>' . "\n";
        }
        echo '@endforeach' . "\n";
        ?>
    </select>    
</div>
