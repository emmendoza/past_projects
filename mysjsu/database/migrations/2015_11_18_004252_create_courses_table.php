<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course');
            $table->integer("seats", false, true);
            $table->timestamps();
        });*/
        Schema::create('courses', function (Blueprint $table) {
            $table->integer('class');
            $table->integer('id')->unsigned()->nullable();
            $table->integer('cid')->unsigned()->nullable(); // class id
            //$table->foreign('cid')->references('cid')->on('requisites');
            $table->string('subject');
            $table->string('courseNumber');
            $table->string('courseName');
            $table->string('section1');
            $table->string('section2');
            $table->string('days');
            $table->string('startTime'); // what format?
            $table->string('endTime'); // what format?
            $table->string('room');
            $table->string('instructor');
            $table->integer('iid')->nullable(); // instructor id
            $table->string('meetingDates');
            $table->integer("seats", false, false)->nullable()
                                                  ->default(35);
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
        Schema::drop('courses');
    }
}
