<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->float('point');
            $table->integer('total_student');
            $table->string('note')->nullable();
            $table->integer('year');
            $table->string('group_keyword');
            $table->integer('major_id');
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
        Schema::dropIfExists('ts_scores');
    }
}
