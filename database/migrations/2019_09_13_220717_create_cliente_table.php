<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('cliente', function(Blueprint $table) {
		    $table->engine = 'InnoDB';
		
            $table->increments('id');
		    $table->string('nome', 255);
		    $table->string('veiculo', 255);
		    $table->integer('telefone')->nullable();
		    $table->string('morada', 255)->nullable();
		    $table->string('email', 255)->nullable();
		    $table->integer('user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('cliente');
    }
}
