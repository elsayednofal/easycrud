<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EasyCrudCrudsFildes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('easy_cruds_fildes', function (Blueprint $table) {
            $table->integer('id',true);
            $table->integer('crud_id');
            $table->string('name');
            $table->string('type');
            $table->text('custom_validation')->nullable();
            $table->text('js_validation')->nullable();
            $table->string('form_type');
            $table->string('static_value')->nullable();
            $table->boolean('is_forgin')->default(FALSE);
            $table->string('related_table')->nullable();
            $table->string('related_column')->nullable();
            $table->string('referance_column')->nullable();
            $table->boolean('is_active')->default(FALSE);
            $table->timestamps();
            
            $table->index('crud_id', 'crud_id_index');
            
            $table->foreign('crud_id')
                    ->references('id')->on('easy_cruds')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('easy_cruds_fildes');
    }
}
