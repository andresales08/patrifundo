<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelPatrimoniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patrimonios', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date');
            $table->integer('fundo_id')->unsigned();
            $table->foreign('fundo_id')->references('id')->on('fundos')->onDelete('cascade')->onUpdate('cascade');
            $table->double('value',10,2);
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
        Schema::dropIfExists('model_patrimonios');
    }
}
