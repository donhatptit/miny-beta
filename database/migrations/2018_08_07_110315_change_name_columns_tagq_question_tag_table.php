<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnsTagqQuestionTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_tag', function (Blueprint $table) {
            $table->renameColumn('tagq_id', 'tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_tag', function (Blueprint $table) {
            $table->renameColumn('tag_id', 'tagq_id');
        });
    }
}
