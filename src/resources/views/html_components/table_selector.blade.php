<select class="form-control" name="{{$name}}" >';
    <option value="">Choose Table Name</option>
    @foreach ($tables as $table)
        <?php $selected = '';?>
        @if (isset($config['selected']) && $config['selected'] == $table)
            <?php $selected = 'selected';?>
        @endif
        <option {{$selected}}>{{$table}}</option>
    @endforeach
</select>