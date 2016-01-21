<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function addClassToCart($course_id) {
        if($this->isStudent()) {
            $data = [
                'user_id' => $this->id,
                'course_id' => $course_id
            ];

            if(DB::table('cart')->where($data)->exists() == false)
                DB::table('cart')->insert($data);
        }
    }
    
    /*public function tryCart($sid,$class){

        //get cid
        $cid = Course::first()->getCid( $class );

        if(!$cid){//if cid does not exist
            return array();
        }

        // get coreq
        $crid = Requisites::first()->getCoreq($cid);
        

        if(!($crid)){ //if no coreq
            return array(); //return empty array
        }

        $matchThese = ['user_id' => $sid, 'course_id' => $crid];
        $matchTheseAlso = ['id' => $sid, 'cid' => $crid];

        if( DB::table('cart')->where( $matchThese )->exists() == true || DB::table('classestaken')->where( $matchTheseAlso )->exists() == true){//if student has coreq in cart
            return array(); //return empty array
        }

        $x = CourseInfo::find( $crid )->subjectNumber();
        $string = "You are missing ".$x." corequisites.";
        return array($string);
    }*/

    public function removeClassFromCart($course_id) {
        if($this->isStudent()) {
            $data = [
                'user_id' => $this->id,
                'course_id' => $course_id
            ];

            if(DB::table('cart')->where($data)->exists())
                DB::table('cart')->where($data)->delete();
        }
    }

    public function gpa() {
        $arr = ClassesTaken::where('id', $this->id)->orderBy('year', 'ASC')
                                                   ->orderBy('semester', 'ASC')
                                                   ->get();

        $n = sizeof($arr);
        $semesters = [];
        $total_gpa = [];

        $i = 0;
        while($i < $n) {
            $prev = $arr[$i]->semester . ' ' . $arr[$i]->year;
            $gpa = [];
            $j = $i;
            while($j < $n && $arr[$j]->semester . ' ' . $arr[$j]->year === $prev) {
                array_push($gpa, $arr[$j]->grade);
                $j++;
            }
            $avg = $this->gpa_avg($gpa);
            if($avg) {
                array_push($semesters, $prev);
                array_push($total_gpa, $avg);
            }
            $i = $j;
        }

        return ['semesters' => $semesters, 'gpa' => $total_gpa];
    }

    public function gpa_avg($gpa) {
        $n = sizeof($gpa);

        if($n > 0 && $gpa[0] === "-")
            return false;

        $total = 0;
        foreach($gpa as $num) {
            switch($num) {
                case "A+":
                    $total += 4;
                    break;
                case "A":
                    $total += 4;
                    break;
                case "A-":
                    $total += 3.7;
                    break;
                case "B+":
                    $total += 3.3;
                    break;
                case "B":
                    $total += 3;
                    break;
                case "B-":
                    $total += 2.7;
                    break;
                case "C+":
                    $total += 2.3;
                    break;
                case "C":
                    $total += 2;
                    break;
                case "C-":
                    $total += 1.7;
                    break;
                case "D+":
                    $total += 1.3;
                    break;
                case "D":
                    $total += 1;
                    break;
                case "D-":
                    $total += 0.7;
                    break;
                default:
                    break;
            }
        }

        return $total / $n;
    }

    public function currentClasses() {
        return array_filter($this->classesTaken(),
            function($class) {
                return $class["grade"] === "-";
            });
    }

    public function pastClasses() {
        return array_filter($this->classesTaken(),
            function($class) {
                return $class["grade"] !== "-";
            });
    }

    public function classesTaken() {
        if($this->isStudent()) {
            $classes_taken = ClassesTaken::where('id', $this->id)
                                ->orderBy('year', 'DESC')
                                ->orderBy('semester', 'ASC')
                                ->get();
            $result = $classes_taken->toArray();

            for($i = 0; $i < sizeof($classes_taken); $i++) {
                $info = $classes_taken[$i]->courseinfo->toArray();
                $class = Course::find($classes_taken[$i]["section_id"]);
                $result[$i]["subjectNumber"] = $info["subjectNumber"];
                $result[$i]["courseName"] = $info["courseName"];
                $result[$i]["instructor"] = $class->instructor;
                $result[$i]["room"] = $class->room;
                $result[$i]["meetingTime"] = $class->meetingTime();
                $result[$i]["class"] = $classes_taken[$i]["section_id"];
            }

            return array_reverse($result);
        }
        return [];
    }

    public function recentSemester()
    {
        $classes = $this->pastClasses();
        $class = sizeof($classes)-1;
        $result = $classes[$class];
        return $result["semester"]. " " . $result["year"];
    }

    public function recentClasses() {
        return array_filter($this->pastClasses(),
            function($class)
            {

                return ($class["semester"] . " " . $class["year"])=== $this->recentSemester();
            });

    }

    public function classesTaught() {
        if($this->isProfessor()) {
            return Course::where('iid', $this->id)->get();
        }
        return "not a professor";
    }

    public function waitlist($section_id) {
        if(Auth::user()->isProfessor())
            return false;

        $waitlist = DB::table('classestaken')->where('id', Auth::user()->id)
                        ->where('section_id', $section_id)
                        ->lists('waitlist')[0];

        $extra = DB::table('classestaken')->where('id', Auth::user()->id)
                    ->where('section_id', $section_id)
                    ->lists('extra')[0];

        return $waitlist && !$extra ;
    }

    /*
    *   Generates Add Code
    *   input-> Class Section ID
    *   output-> Code
    */
    public function generateAddCode( $class_id ){
        $count = DB::table('addcodes')->count();
        $x = md5(microtime(true));
        $code = strtoupper(substr($x,0,6));
        if($this->isProfessor()){
            $id = DB::table('addcodes')->insertGetId(
                ['class_id' => $class_id, 'code' => $code]
            );
            return $code;
        }
        return null;
    }
    /*
    *   Return Active Codes
    *   input-> Class Section ID
    *   output-> list of codes
    */
    public function returnActiveCodes( $class_id ){
        if($this->isProfessor()){
            if(DB::table('addcodes')->where('class_id','=',$class_id)->exists()){
                $list = DB::table('addcodes')->where('class_id','=',$class_id)->get();
                return $list;
            }else{
                return array();
            }
        }
    }
    //useAddCode check if student, section in & add code, 
    //remove from table,
    //call enroll on user
    public function useAddCode( $code ){
        if($this->isStudent()) {
            if(DB::table('addcodes')->where(['code'=> $code])->exists()){
                $x = DB::table('addcodes')->where(['code'=> $code])->first();
                $class_id = $x->class_id;
                
                $dataForCartRemoval = [
                    'user_id' => $this->id,
                    'course_id' => $class_id
                ];
                $dataForAddCodesRemoval = [
                    'code' => $code,
                    'class_id' => $class_id
                ];
                //$entry = DB::table('addcodes')->where($dataForAddCodesRemoval);
                //if class exists in student cart.
                if(DB::table('cart')->where($dataForCartRemoval)->exists()){

                    //INSERT FUNCTION TO ADD CLASS TO CLASSESTAKEN TABLE
//                    $course = Course::find($class_id);
//                    $course->enroll(true);
                    DB::table('classestaken')->where(['id' => $this->id, 'section_id' => $class_id])
                                             ->update(['extra' => true]);

                    //cmd to remove class from cart
                    DB::table('cart')->where($dataForCartRemoval)->delete();

                    //removes add code from addcodes table
                    DB::table('addcodes')->where($dataForAddCodesRemoval)->delete();
                    $result = "You have successfully enrolled into section ".$class_id.".";
                    return $result;
                }
                return "You do not have this course in your cart.";
            }
            return "You have entered an invalid add code.";
        }
    }

    /*
     * returns all courses in shopping cart
     */
    public function cart() {
        return $this->belongsToMany('App\Course', 'cart', 'user_id', 'course_id');
    }

    public function isStudent() {
        return $this->id >= 39;
    }

    public function isProfessor() {
        return $this->id <= 38;
    }
}
