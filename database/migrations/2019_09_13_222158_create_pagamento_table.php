<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('pagamento', function(Blueprint $table) {
		    $table->engine = 'InnoDB';
		
            $table->increments('id');
		    $table->integer('estado')->nullable();
		    $table->integer('forma_pagamento');
		    $table->integer('valor_pago');
		    $table->integer('user_id')->unsigned();
		    $table->integer('servico_id')->unsigned();
		    $table->integer('cliente_id')->unsigned();
		    		
		    $table->foreign('user_id')
		        ->references('id')->on('users');
		
		    $table->foreign('servico_id')
		        ->references('id')->on('servico');
		
		    $table->foreign('cliente_id')
		        ->references('id')->on('cliente');
		
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
        Schema::dropIfExists('pagamento');
    }
}
