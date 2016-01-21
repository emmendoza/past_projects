<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseInfo extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courseinfo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['course', 'seats'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];

    /**
     * Gets the prerequisites associated with the given course id
     *
     * @var array
     */


    public function subjectNumber() {
        return $this->subjectNumber;
    }
    public function courseName() {
        return $this->courseName;
    }
}
