<?php echo '@extends('.config("EasyCrud.backend_layout").')' . "\n"; ?>

<?php echo '@section("title")Update ' . $crud->name . ' @stop' . "\n"; ?>

<?php echo '@section('.config("EasyCrud.layout_content_area").')' . "\n"; ?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
@if(App::getLocale()!='en')
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/localization/messages_{{App::getLocale()}}.js"></script>
@endif

<div class="row" style="background-color: #FFFFFF;    padding: 0 10px 0px 10px;">
    <h2>{{kebab_case(ucfirst(camel_case($crud->name)))}}</h2>
    <ol class="breadcrumb">
      <li><a href="javascript:void()">Home</a></li>
      <li><a href="./{{config('EasyCrud.url_prefix')}}/{{kebab_case(ucfirst(camel_case($crud->name)))}}">{{$crud->name}}</a></li>
      <li class="active">Update</li>
    </ol>
</div>

<br style="clear:both">

<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">Update {{$crud->name}}</h3></div>
    <div class="panel-body">
    <?php echo '<?php if(Session::has("success")): ?> ' . "\n"; ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <strong>Congratulations : </strong><?php echo '<?= session("success") ?>'; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    <?php echo '<?php elseif(Session::has("validate_errors")): ?> ' . "\n"; ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Validate Errors</strong><br/><?php echo '<?= session("validate_errors") ?>'; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php echo '<?php endif; ?>' . "\n"; ?>
    
    <?php echo '@include("backend.' . $crud->name . '._form")' . "\n"; ?>
        
    </div>
</div>

<style>
    .form-control.error {
        border-color: #ef2b2b;
    }
    .error {
        color: #ef2b2b !important;
    }
</style>

<?php echo '@stop'; ?>

