<select name="{{$name}}" class="form-control">';
    <option value="">Choose Model</option>
    @foreach ($models as $model) {
        <?php $selected = '';?>
        @if (isset($config['selected']) && $config['selected'] == $model)
            <?php $selected = 'selected';?>
        @endif
       <option>{{$model}}</option>
    @endforeach
</select>

