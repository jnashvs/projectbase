<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuprimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('suprimento', function(Blueprint $table) {
		    $table->engine = 'InnoDB';
		
            $table->increments('id');
		    $table->string('nome', 255);
		    $table->integer('quantidade');
		    $table->integer('estado')->nullable();
		    $table->integer('user_id')->unsigned();
		    				
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
        Schema::dropIfExists('suprimento');
    }
}
