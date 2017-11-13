<select name="{{$name}}" class="form-control">';
    @foreach ($types as $type) {
       <option>{{$type}}</option>
    @endforeach
</select>