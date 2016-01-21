<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller
{
    /*
     * localhost/index.php/api?data=courses
     */
    public function main(Request $request) {
        switch($request->data) {
            case "courses":
                $courses = Course::all();
                foreach($courses as $course) {
                    $course["status"] = $course->seatsStatus();
                    $course["enrolled"] = $course->totalEnrolled();
                    $course["waitlist"] = $course->totalWaitlisted();
                }
                return response()->json(['courses' => $courses]);

            case "gpa":
                if($request->has('student_id')) {
                    $student = User::find($request->get('student_id'));
                    return $student->gpa();
                }
                else {
                    return [];
                }

            case "classestaken":
                return Auth::user()->pastClasses();

            case "activecodes":
                $section_id = $request->get('section_id');
                return Auth::user()->returnActiveCodes($section_id);

            case "generateaddcode":
                $section_id = $request->get('section_id');
                Auth::user()->generateAddCode($section_id);
                return redirect()->action('CoursesController@addCode');
            default:
                return "no data specified";
        }
    }
}
