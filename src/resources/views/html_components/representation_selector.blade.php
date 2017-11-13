<select class="form-control representation" name="{{$name}}">
    @foreach ($types as $type)
    <?php $selected = ''; ?>
    @if (isset($config['selected']) && $config['selected'] == $type)
    <?php $selected = 'selected'; ?>
    @endif
    <option {{$selected}}>{{$type }}</option>
    @endforeach
</select>

