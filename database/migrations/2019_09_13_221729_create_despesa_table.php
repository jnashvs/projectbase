<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespesaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('despesas', function(Blueprint $table) {
		    $table->engine = 'InnoDB';
		
            $table->increments('id');
		    $table->integer('estado');
		    $table->text('descricao');
		    $table->integer('valor');
		    $table->integer('funcionario_id')->unsigned();
		    $table->integer('user_id')->unsigned();
		    		
		    $table->foreign('funcionario_id')
		        ->references('id')->on('funcionario');
		
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
        Schema::dropIfExists('despesa');
    }
}
