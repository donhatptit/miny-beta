<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->nullable();
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
            $table->string('name');
            $table->string('player')->nullable();
            $table->string('slug')->unique();
            $table->tinyInteger('type')->default(0);
            $table->string('code')->unique()->index()->nullable();
            $table->integer('is_public')->default(0);
            $table->integer('is_approve')->default(0);
            $table->string('unapprove_reason')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();

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
        Schema::dropIfExists('questions_categories');
    }
}
