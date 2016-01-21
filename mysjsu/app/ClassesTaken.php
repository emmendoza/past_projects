<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CourseInfo;

//include(app_path().'/hashTables.php');

class ClassesTaken extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classestaken';

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

    /*
    public function requisites() {
        return $this->hasMany('App\Requisites', 'cid', 'cid');
    }
    public function requisitesToString(){
        $results = $this->requisites;
        $x = "Prerequisites: ";

        foreach ($results as $row) {
            if($row->ORprid){
                $prid = CourseInfo::find( $row->prid )->subjectNumber();
                $ORprid = CourseInfo::find( $row->ORprid )->subjectNumber();
                $x .= $prid." or ".$ORprid.", ";
            }elseif($row->prid){
                    $prid = CourseInfo::find( $row->prid )->subjectNumber();
                    $x.= $prid.", ";
                
            }
            if($row->crid){
                $crid = CourseInfo::find( $row->crid )->subjectNumber();
                $x .= "Corequisite: ".$crid.", ";
            }
        }
        $x = substr($x,0,-2);//strip last comma
        return $x;
        //return $string;
        //return $this->instructor;
    }
    */
    public function courseinfo() {
        return $this->hasOne('App\CourseInfo', 'id', 'cid');
    }
    

    public function getClasses($sid){
        return ClassesTaken::find($sid);
        //return "apples";
    }
    /*
    public function corequisites() {
        return $this->belongsToMany('App\Course', 'requisites', 'cid', 'crid');
    }*/
}
