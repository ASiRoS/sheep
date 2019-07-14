<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('general_sheep_count');
            $table->integer('alive_sheep_count');
            $table->integer('killed_sheep_count');
            $table->unsignedBigInteger('biggest_cage_id');

            $table->foreign('biggest_cage_id')->references('id')->on('cages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
