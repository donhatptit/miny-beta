<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTsScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('ts_scores');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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
}
