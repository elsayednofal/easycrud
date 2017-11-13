<select name="{{$name}}" class="form-control">';
    @foreach ($columns as $column=>$type) {
       <option>{{$column}}</option>
    @endforeach
</select>