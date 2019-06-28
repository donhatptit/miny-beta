<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTsUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_universities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('vi_name');
            $table->string('en_name')->nullable();
            $table->string('slug');
            $table->string('keyword')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->string('established')->nullable();
            $table->text('avatar')->nullable();
            $table->integer('type')->nullable();
            $table->string('organization')->nullable();
            $table->string('scale')->nullable();
            $table->integer('kind')->nullable();
            $table->integer('location_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('is_public')->default(0);
            $table->integer('is_approve')->default(0);
            $table->integer('created_by');
            $table->integer('edited_by')->default(0);
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
        Schema::dropIfExists('ts_universities');
    }
}
