<?php

use Elsayednofal\EasyCrud\Http\Helpers\HtmlComponent; ?>
@extends('EasyCrud::layout.master')
@section('content')
<div class="row">
    <div class="col-md-10">
        <h1 style="text-align: center;">Curd Builder</h1>
        <br>
        <form method="post" action="{{url('easy-crud/save')}}" id="crud_data" >
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Choose Table</label>
                        <?= HtmlComponent::tablesSelector('main_table[name]') ?>
                    </div>
                </div>
                <div class="col-md-2" style="display: none">
                    <div class="form-group">
                        <label class="control-label">Choose Type</label>
                        <?= HtmlComponent::tablesTypes('main_table[type]')?>
                    </div>
                </div>
                <div class="col-md-5 model-section">
                    <br/>
                    <button type="button" id="model-columns" class="btn btn-primary btn-sm">Show Column & Models</button>
                    <button style="display: none" type="button" id="check-model" class="col-md-5 btn btn-success btn-sm btn-outline">Check Model</button>
                    <button style="display: none" type="button" id="go" class="col-md-5 offset-md-1 btn btn-primary btn-sm btn btn-outline">Check Colums</button>
                </div>

            </div>
            <br/>
            <div class="row" id="model-result"></div>
            <br/>
            <div class="row" id="content-area"></div>
        </form>
    </div>
    <div class="col-md-2" id="crud-messages" style="border-left: 1px solid"></div>
</div>
    
<div class="bind" style="display: none">
    <button class="btn btn-warning btn-sm" data-id="" type="button" id="generate">Generate Files</button>
    <div id="loader" style="text-align: center;">
        <img src="{{url('vendor/elsayednofal/EasyCrud/images/loader.gif')}}" />
    </div>
</div>
<style>
    h2{
        color:rgba(0, 8, 253, 0.65);
    }
    .message{
            display: block;
        width: 100%;
        margin-bottom: 10px;
        padding: 20px;
    }
</style>
@stop

@section('footer-js')
<script type="text/javascript">
    $(document).ready(function () {
        
        $('#model-columns').click(function(){
           $('#check-model').trigger('click'); 
           setTimeout(function(){
                $('#go').trigger('click');
           },1500);
           
        });
        
        $('#check-model').click(function(){
           var table_name = $('select[name="main_table[name]"] option:selected').val();
           $.ajax({
               url:'./easy-crud/check-model/'+table_name,
               beforeSend: function (xhr) {
                        $('#model-result').html('');
                        $('#check-model').attr('disable');
                },
               success:function(response){
                  response=jQuery.parseJSON(response);
                   console.log(response);
                   for(var i in response){
                       if(i==='0'){
                            var html=modelFile(response[i].namespace,response[i].generated,response[i].is_valide,response[i].table_name);
                            $('#model-result').append(html);
                       }
                   }
                    resultMessage('show model result','success');
               }
           }).done(function(){
               $('#check-model').removeAttr('disable');
           });
        });
        
        function modelFile(namespace,generated,is_valide,table_name){
            var bg='success';
            var modified='exist';
            if(generated){
                bg='warning';
                modified='auto generated';
            }
            var html= '<div class=" model-check-result alert alert-'+bg+' col-md-12" >\n\
                     <h3>Related Models : </h3><br/>\n\
                    <p class="model_path"> '+namespace+' , '+modified+' </p>\n';
            if(modified==='exist'){
                if(is_valide){
                    html+='<p>Model seem to be valide to use with Easy Crud </p>';
                }else{
                    html+='<p style="color:red">Model seem not valide to use with with our Crud genrator</p>';
                    html+='<button type="button" class="btn btn-outline-warning" id="re-generate-model" value="'+table_name+'">Re-Generate</button>';
                }
            
            }
            html+='<input type="hidden" name="main_table[model]" value="'+namespace+'" />\n\
                   </div>';
            
            return html;
        }
        
        $(document).on('click','#re-generate-model',function(){
            
            var table_name=$(this).val();
            btn_grnerate=$(this);
            $.ajax({
               url:'./easy-crud/re-genrate-model/'+table_name,
               beforeSend: function (xhr) {
                        btn_grnerate.hide();
                },
                success:function(response){
                    response=jQuery.parseJSON(response);
                    if(response.status==='ok'){
                        for(var i in response.data){
                            if(i==='0'){
                                var html=modelFile(response.data[i].namespace,response.data[i].generated,response.data[i].is_valide,response.data[i].table_name);
                                $('#model-result').html(html);
                            }
                        }
                        esultMessage(response.message,'success');
                    }else{
                        esultMessage(response.message,'error');
                    }
                    
                }
            }).done(function(){
               btn_grnerate.show();
           });;
        });
        
        $('#go').click(function () {
            $(this).hide();
            var table_name = $('select[name="main_table[name]"] option:selected').val();
            $.ajax({
                url: './easy-crud/table-fileds',
                method: 'post',
                data: {table_name: table_name},
                beforeSend: function (xhr) {
                    $('#content-area').html('');
                     showLoading();   
                },
                success: function (response) {
                    hideLoading();
                    response = jQuery.parseJSON(response);
                    if (response.status==='ok'){
                        $('#content-area').html(response.data);
                        resultMessage(response.message,'success');
                    }else{
                        $('#content-area').html(response.data);
                        resultMessage(response.message,'danger');
                    }
                   // $('#go').show();
                }
            });
        });
        
        $("#crud_data").submit(function (e){
            e.preventDefault();
            form=$(this);
            $.ajax({
                   type: "GET",
                   url: "{{url('easy-crud/save')}}",
                   data: $("#crud_data").serialize(), 
                   beforeSend: function (xhr) {
                      // $('#content-area').html('');
                       $(form).find('#submit').hide();
                     showLoading();   
                    },
                   success: function(json)
                   {
                        hideLoading();
                       var response=jQuery.parseJSON(json);
                       if(response.status==='ok'){
                           //$('#content-area').html(response.data);
                           loadgenerateForm(response.id);
                            resultMessage('save crud data succussfully','success');
                       }else{
                           // $('#content-area').prepend(response.data+'<br/>');
                           $(form).find('#submit').show();
                            resultMessage(response.data,'danger');
                       }
                   }
                 });

        });
        
        
        $(document).on('click','#generate',function (){
            var id=$(this).data('id');
            $.ajax({
                url:'./easy-crud/generate?id='+id,
                beforeSend: function (xhr) {
                    $('#content-area').find('#generate').hide();
                     showLoading();   
                },
                success: function (response) {
                    hideLoading();
                    var response=jQuery.parseJSON(response);
                    if(response.status==='ok'){
                       // $('#content-area').html(response.message);
                        $('#content-area').append('<a href="'+response.data.url+'">View Result</a>');
                        resultMessage(response.message,'success');
                    }else{
                        $('#content-area').html(response.message);
                         $('#content-area').find('#generate').show();
                    }
                }
                
            });
        });
        
        function loadgenerateForm(id){
            $('#content-area').append('<br />');
            $('.bind').find('#generate').clone().appendTo('#content-area');
            $('#content-area').find('#generate').attr('data-id',id);
        }
        
        function showLoading(){
            $('.bind').find('#loader').clone().appendTo('#content-area');
        }
        
        function hideLoading(show_content=true){
            $('#content-area').find('#loader').remove();
        }
        
        function resultMessage(message,type){
            var html='<div class="alert alert-'+type+' alert-dismissable" style="font-size:11px;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+message+'</div>';
            $('#crud-messages').append(html);
                
                if(type==='danger'){
                    type='error';
                }
                swal({
                    title: type,
                    text: message,
                    type: type,
                    html: true,
                    showConfirmButton: true
                });
        }
        
        $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function(){
            $(this).slideUp(500);
        });
    });
</script>
@stop