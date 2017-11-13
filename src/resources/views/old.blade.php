@extends('EasyCrud::layout.master')
@section('content')
<div class="row">
    <div class="col-md-10">
        <table class="table">
            <thead>
                <tr>
                    <th>Crud Table</th>
                    <th>Generated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cruds as $crud)
                <tr class="crud-row">
                    <td>{{$crud->name}}</td>
                    <td>@if($crud->is_genrated==1)<p>&#10004</p>@else<p>Not generated</p>@endif</td>
                    <td>
                        <a href="{{url('./easy-crud/delete/'.$crud->id)}}" title="Delete Configration only , not files" class="btn btn-outline-danger delete">Remove</a>
                        <a href="{{url('./easy-crud/generate?id='.$crud->id)}}" class="btn btn-outline-success generate">
                            @if($crud->is_genrated==1)
                            Re-Generate
                            @else
                            Generate
                            @endif
                        </a>
                        <img src="{{url('vendor/elsayednofal/EasyCrud/images/loader.gif')}}" style="max-width:100px;display: none" class="loader"/>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="messages-area" style="border-left: 1px solid">

    </div>
</div>
@stop
@section('footer-js')
<script type="text/javascript">
    $(document).ready(function () {
        $('.delete').click(function (e) {
            e.preventDefault();
            delete_btn = $(this);
            if (!confirm('are you sure you want to remove this row'))
                return false;
            $.ajax({
                beforeSend: function (xhr) {
                    delete_btn.attr("disabled", "disabled");
                    delete_btn.closest('td').find('loader').show();
                },
                url: delete_btn.attr('href'),
                success: function (response) {
                    if (response === 'ok') {
                        delete_btn.html('<p>&#10004</p>');
                        delete_btn.closest('tr').remove();
                        resultMessage('row deleted successfully', 'success');
                    } else {
                        resultMessage('Oops , something went wrong !', 'error');
                        delete_btn.removeAttr("disabled");
                    }
                }

            }).done(function () {
                delete_btn.closest('td').find('loader').hide();
            });
        });
        
        $('.generate').click(function(e){
            e.preventDefault();
            var generate_btn=$(this);
            if(!confirm('Are you sure you want to generate files')){
                return false;
            }
            $.ajax({
                beforeSend: function (xhr) {
                    generate_btn.attr("disabled", "disabled");
                    generate_btn.closest('td').find('loader').show();
                },
                url: generate_btn.attr('href'),
                success: function (response) {
                    response=jQuery.parseJSON(response);
                    if (response.status === 'ok') {
                        generate_btn.closest('td').append('<a href="'+response.data.url+'">View Result</a>');
                        resultMessage(response.message, 'success');
                        generate_btn.remove();
                    } else {
                        resultMessage('Oops , something went wrong !', 'error');
                        generate_btn.removeAttr("disabled");
                    }
                }

            }).done(function () {
                generate_btn.closest('td').find('loader').hide();
            });
        });
        
        
        function resultMessage(message, type) {
            var html = '<div class="alert alert-' + type + ' alert-dismissable" style="font-size:11px;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + message + '</div>';
            $('.messages-area').append(html);

            if (type === 'danger') {
                type = 'error';
            }
            swal({
                title: type,
                text: message,
                type: type,
                html: true,
                showConfirmButton: true
            });
        }
    });
</script>
@stop