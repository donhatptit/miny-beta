<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexPostAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_answer', function (Blueprint $table) {
            $table->index('post_id', 'post_id_in_post_answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_answer', function (Blueprint $table) {
            $table->dropIndex('post_id_in_post_answer');
        });
    }
}
