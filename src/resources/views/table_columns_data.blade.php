<?php

use Elsayednofal\EasyCrud\Http\Helpers\HtmlComponent;
?>
<h2>Choose columns [create,update]</h2>
<div class="col-md-12">
    <table class="table table-striped table-inverse">
        <thead>
            <tr>
                <th>check</th>
                <th>Column Name</th>
                <th>Column Type</th>
                <th>Column Relation</th>
                <th>From data type</th>
                <th>relation show</th>
                <th>static values <br/><span style="font-size: 12px;color:gray;">values spearated with ;</span></th>
            </tr>
        </thead>
        <tbody>
        @foreach($columns as $column=>$type)
            <tr>
                <td>
                    @if($columns_property[$column]->Null=='NO')
                        @if($columns_property[$column]->Extra!='auto_increment')
                            <input type="hidden" name="{{$table_name}}[{{$column}}][is_active]" value="1" />
                            <p>&#10004</p>
                        @else
                            <p>&#10006</p>
                        @endif
                    @else
                        <input type="checkbox" name="{{$table_name}}[{{$column}}][is_active]" value="1" />
                    @endif
                </td>
                <td>{{$column}}</td>
                <td>{{$type}}</td>
                <td>
                    @if(isset($relations[$column])) 
                        {{$relations[$column]['referenced_table_name'].' -> '.$relations[$column]['referenced_column_name']}}
                    @endif
                </td>
                <td>
                    <input type="hidden" name="{{$table_name.'['. $column .'][type]'}}" value="{{$type}}" />
                    <?php $form_type = HtmlComponent::convertSqlDataTypeToFormDataType($type, $column, isset($relations[$column])); ?>
                    <?= HtmlComponent::representationSelector($table_name . "[" . $column . "][form_type]", ['selected' => $form_type]) ?>
                </td>
                <td>
                    @if(isset($relations[$column]))
                        <input type="hidden" name="{{$table_name.'['. $column .'][is_forgin]'}}" value="1" />
                        <input type="hidden" name="{{$table_name.'['. $column .'][related_table]'}}" value="{{$relations[$column]['referenced_table_name']}}" />
                        <input type="hidden" name="{{$table_name.'['. $column .'][referance_column]'}}" value="{{$relations[$column]['referenced_column_name']}}" />
                        <?= HtmlComponent::tableColumnsSelestor($table_name . "[" . $column . "][related_column]", ['table_name' => $relations[$column]['referenced_table_name']]) ?>
                    @endif
                </td>
                <td class="static-values">
                    <textarea style="display: none" name="{{$table_name.'['. $column .'][static_value]'}}" class="form-control"></textarea>
                </td>
            </tr>
        @endforeach
        <tbody>
    </table>
</div>
<br/>
<h2>Choose Index Show Columns</h2>
<br/>
<div class="col-md-12">
    <div class="row">
        @foreach($columns as $column=>$type)
            <div class="col-md-2">
                <div class="form-group">
                    <input type="checkbox" name="indexs_show[]" value="{{$column}}" />
                    <label class="control-label">{{$column}}</label>
                </div>
            </div>
        @endforeach
    </div>
</div>

<button type="submit" id="submit" class="btn btn-outline-success" >Save</button> 

<script type="text/javascript">
$(document).ready(function(){
  $('.representation').change(function(){
      var selected=$(this).find(":selected").val();
      if(selected==='Select Box' || selected==='Hidden value'){
          $(this).closest('tr').find('td.static-values').find('textarea').show();
      }else{
          $(this).closest('tr').find('td.static-values').find('textarea').hide();
      }
  });  
});  


</script>