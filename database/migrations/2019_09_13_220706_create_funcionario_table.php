<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('funcionario', function(Blueprint $table) {
		
            $table->increments('id');
		    $table->string('nome', 255);
		    $table->integer('categoria');
		    $table->string('morada', 255);
		    $table->integer('telefone')->nullable();
		    $table->string('email', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->unsignedInteger('user_id');
		    $table->integer('estado');
		    				
		    $table->foreign('user_id')
		        ->references('id')->on('users');
		
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
        Schema::dropIfExists('funcionario');
    }
}
