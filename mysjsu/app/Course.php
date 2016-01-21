<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CourseInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//include(app_path().'/hashTables.php');

class Course extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

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

    public function enrolledStudents() {
        $students = [];
        $ids = DB::table('classestaken')->where('section_id', $this->id)
                                        ->lists('id');
        foreach($ids as $id)
            array_push($students, User::find($id));

        return $students;
    }

    public function totalEnrolled() {
        return ($this->seats < 0) ? 35 + $this->extra() : 35 - $this->seats;
    }

    public function totalWaitlisted() {
        return ($this->seats < 0) ? abs($this->seats) - $this->extra() : 0;
    }

    public function meetingTime() {
        return $this->days . ' ' . $this->startTime . '-' . $this->endTime;
    }

    public function extra() {
        return DB::table('classestaken')->where('section_id', $this->id)
                                        ->where('extra', true)
                                        ->count();
    }

    public function enroll($extra = false) {
        $user_id = Auth::user()->id;
        $section_id = $this->id;
        $course_id = $this->cid;
        $semester = "Spring";
        $year = "2016";
        $grade = "-";
        $eligible = $this->tryEnroll($user_id, $section_id);

        if(!$eligible) {
            DB::table('classestaken')->insert([
                'id' => $user_id,
                'cid' => $course_id,
                'section_id' => $section_id,
                'semester' => $semester,
                'year' => $year,
                'grade' => $grade,
                'waitlist' => $this->totalWaitlisted() >= 0 ,
                'extra' => $extra
            ]);
            Auth::user()->removeClassFromCart($section_id);
            $this->decSeats();
        }
        return $eligible;
    }

    /*  Returns a string of Seats Status
    */  
    public function seatsStatus(){
        if( $this->seats > 0 ){
            return "Open";
        }elseif( $this->seats <= 0 && $this->seats > -15 ){
            return "Waitlisted";
        }else{
            return "Closed";
        }
    }

    private function incSeats() {
        // Increment seats
        $this->seats++;
        $this->save();
    }

    private function decSeats() {
        // Decrement seats
        $this->seats--;
        $this->save();
    }

    /**
     * Gets the prerequisites associated with the given course id
     *
     * @var array
     */

    public function requisites() {
        return $this->hasMany('App\Requisites', 'cid', 'cid');
    }

    /*
     * Returns a formatted string of Prerequisites and Corequisites of a given 'class'
     */
    public function genAddCode(){
        return crc32(2);
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
    public function getCid($class){
        if(Course::where('class','=',$class)->exists())
            return Course::where('class','=',$class)->first()->cid;
        return null;
    }

    public function tester($id){
        return CourseInfo::find( $id )->subjectNumber();
    }

    /*
     * First Parameter is Student ID, Second Parameter is Class Section ID
     * @returns empty array if successful, else array
     */
    public function tryEnroll( $sid , $class ){
        //Get Cid
        $cid = Course::first()->getCid( $class );
        
        // Check if Student has taken the class.
        $x = ClassesTaken::where('id', $sid )->where('cid','=',$cid)->first();
        if($x){
            return array("You have already taken this course.");//return false;
        }else{


            $list = Course::where('cid','=',$cid)->first()->requisites;

            //if list is empty, return null;
            //if(!($list))
                //return array();

            $results = array();
            foreach ($list as $row) {
                //IF Prerequisite OR Prerequisite, check both
                if($row->ORprid){

                    $get1 = ClassesTaken::find( $sid )->where('cid','=',$row->prid)->first();
                    $get2 = ClassesTaken::find( $sid )->where('cid','=',$row->ORprid)->first();
                    
                    //If student hasn't taken both courses
                    if( !($get1 || $get2) ){
                        $x = CourseInfo::find( $row->prid )->subjectNumber();
                        $y = CourseInfo::find( $row->ORprid )->subjectNumber();
                        $result = "You are missing ".$x." or ".$y." prerequisites.";
                        array_push($results,$result);//return false;
                    }

                }elseif($row->prid){

                    $hit = ClassesTaken::find( $sid )->where('cid','=',$row->prid)->first();

                    if(!($hit)){
                        $y = CourseInfo::find( $row->prid )->subjectNumber();
                        $result = "You are missing ".$y." prerequisite.";
                        array_push($results,$result);//return false;
                    }
                }
            }
            return $results;//return true;

        }

    }

    public function tryEnrollGen( $sid , $cid ){
        //Get Cid
        //$cid = Course::first()->getCid( $class );
        
        // Check if Student has taken the class.
        $x = ClassesTaken::where('id', $sid )->where('cid','=',$cid)->exists();
        if($x){
            return false;//array("You have already taken this course.");//return false;
        }else{
            
            if(Course::where('cid','=',$cid)->exists())
                $list = Course::where('cid','=',$cid)->first()->requisites;

            //if list is empty, return null;
            if(!($list))
                return true;//array();

            $results = array();
            foreach ($list as $row) {
                //IF Prerequisite OR Prerequisite, check both
                if($row->ORprid){

                    $get1 = ClassesTaken::find( $sid )->where('cid','=',$row->prid)->first();
                    $get2 = ClassesTaken::find( $sid )->where('cid','=',$row->ORprid)->first();
                    
                    //If student hasn't taken both courses
                    if( !($get1 || $get2) ){
                        //$x = CourseInfo::find( $row->prid )->subjectNumber();
                        //$y = CourseInfo::find( $row->ORprid )->subjectNumber();
                        //$result = "You are missing ".$x." or ".$y." prerequisites.";
                        return false;//array_push($results,$result);//return false;
                    }

                }elseif($row->prid){

                    $hit = ClassesTaken::find( $sid )->where('cid','=',$row->prid)->first();

                    if(!($hit)){
                        //$y = CourseInfo::find( $row->prid )->subjectNumber();
                        //$result = "You are missing ".$y." prerequisite.";
                        return false;//array_push($results,$result);//return false;
                    }
                }
            }
            return true;//$results;//return true;

        }

    }

}
