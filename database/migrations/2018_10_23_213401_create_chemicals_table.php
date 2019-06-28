<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChemicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chemicals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('symbol');
            $table->string('name_vi')->nullable();
            $table->text('name_eng')->nullable();
            $table->string('color')->nullable();
            $table->string('state')->nullable();
            $table->string('g_mol')->nullable();
            $table->string('kg_m3')->nullable();
            $table->string('boiling_point')->nullable();
            $table->string('melting_point')->nullable();
            $table->string('electronegativity')->nullable();
            $table->string('ionization_energy')->nullable();
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
        Schema::dropIfExists('chemicals');
    }
}
