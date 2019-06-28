<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewChemicalEquationTable extends Migration
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
            $table->text('equation');
            $table->text('condition')->nullable();
            $table->text('execute')->nullable();
            $table->text('phenomenon')->nullable();
            $table->text('extra')->nullable();
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
