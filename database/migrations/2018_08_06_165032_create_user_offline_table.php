<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOfflineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_offline', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('target_id');
            $table->string('type')->default('post');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'target_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_offline');
    }
}
