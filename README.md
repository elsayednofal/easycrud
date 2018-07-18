# EasyCrud
This package to generate model and crud from database table and add it to laravel backend.

# Dependancy 
 1- model generator package from url : https://github.com/hosamaldeen/laracrud
 
 2- image Manager package from url : https://github.com/elsayednofal/imagemanager

### Installation
  
- install package by run command `composer require elsayednofal/easycrud:dev-master`
- add service provider to config/app.php 

`Elsayednofal\EasyCrud\EasyCrudServiceProvider::class,
 Elsayednofal\Imagemanager\ImageManagerServiceProvider::class,
 Hosamaldeen\LaraCRUD\LaraCRUDServiceProvider::class,
 Elsayednofal\EasyCrud\EasyCrudRouteServiceProvider::class,`

- in alias add the line
`ImageManager' => Elsayednofal\Imagemanager\Http\Controllers\Facades\ImageManager::class`

- publish assets with command `php artisan vendor:publish`
- add easycrud tables to database with command `php artisan migrate`

### Configration

>you can edit your configration throw file config/easycrud.php
- "backend_layout" the path to your layout blade of backend
 like `'backend_layout'=>'backend.layout.master',`

- "layout_content_area" the yield section of content 
like `'layout_content_area'=>'content',`

- "middlewares" the array of middleware names should be added to any genrated crud 
like `'middlewares'=>['auth','is_admin' ],`

- "url_prefix" the url prefix for backend or admin area should be add before crud name in url like `'url_prefix'=>'backend',` the url should br "./public/backend/products"

- "controllers_directory" the folder in app\http\controller directory to put generated controller into it , like `"controllers_directory"=>"backend",`

- "templates_path" the templete path which crud generate any file from it , like `"templates_path"=>"backend"`


### Usage
- run url `{your app path}/easy-crud`
- choose table from select box and press "show model&colums"

> you will see the path of generated model 
> you also get the table columns to choose theme and relation in database 

- click save and then generate 
- then you should show link to you crud 

### Old cruds 
you can find your old crud and regenrate it by calling url : 
    `{your app path}/easy-crud/old`


 ## Edit crud templete
> The easycrud package publish templete file that built any crud from it , It publish it in the path that define in config file "config/easycrud.php" in key "templates_path"

> The temolete made to work with any backend theme in bootstrap and jquery

so if you want to customize the templte you should edit files in that path
