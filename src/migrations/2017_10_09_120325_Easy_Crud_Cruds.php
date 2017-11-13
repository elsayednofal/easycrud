<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EasyCrudCruds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('easy_cruds', function (Blueprint $table) {
            $table->integer('id',true);
            $table->string('name')->unique();
            $table->string('model');
            $table->string('type');
            $table->text('index_fildes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('easy_cruds');
    }
}
