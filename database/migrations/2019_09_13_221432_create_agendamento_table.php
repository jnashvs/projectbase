<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('agendamento', function(Blueprint $table) {
		    $table->engine = 'InnoDB';
		
            $table->increments('id');
		    $table->text('descricao');
		    $table->string('titulo', 400);
		    $table->integer('user_id')->unsigned();
		    $table->integer('estado')->nullable();
		    $table->string('horario', 255);
		    $table->integer('cliente_id')->unsigned();
		    		
		    $table->foreign('user_id')
		        ->references('id')->on('users');
		
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
        Schema::dropIfExists('agendamento');
    }
}
