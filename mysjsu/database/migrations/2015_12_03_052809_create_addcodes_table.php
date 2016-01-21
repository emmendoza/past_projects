<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('class_id')->unsigned()
                                         ->references('class')
                                         ->on('courses');
            $table->string('code');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('addcodes');
    }
}
