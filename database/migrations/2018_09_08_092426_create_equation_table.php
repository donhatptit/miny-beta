<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chemical_equations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->text('equation');
            $table->text('status')->nullable();
            $table->text('calculate')->nullable();
            $table->text('condition')->nullable();
            $table->text('how_to')->nullable();
            $table->text('phenomenon')->nullable();
            $table->text('content_info')->nullable();
            $table->text('question')->nullable();
            $table->text('extra');
            $table->integer('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chemical_equations');
    }
}
