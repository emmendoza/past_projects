<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->id <= 38)
            return view('professors.courses.index', ['courses' => Course::all()]);
        else
            return view('students.courses.index', ['courses' => Course::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_id)
    {
        if(Auth::user()->isProfessor()) {
            return view('professors.courses.show', ['class' => Course::find($course_id)]);
        }
        else {
            return view('students.courses.show');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dropClass(Request $request) {
        if($request->has('student_id') && $request->has('section_id')) {
            $student_id = $request->get('student_id');
            $section_id = $request->get('section_id');

            DB::table('classestaken')->where('id', $student_id)
                                     ->where('section_id', $section_id)
                                     ->delete();
        }

        return redirect()->back();
    }

    public function addToCart(Request $request) {
        if($request->has('course_id')) {
            $course_id = $request->get('course_id');
            Auth::user()->addClassToCart($course_id);
            return redirect()->action('CoursesController@enroll');
        }
        else {
            return redirect()->back();
        }
    }

    public function removeFromCart(Request $request) {
        if($request->has('course_id')) {
            $course_id = $request->get('course_id');
            Auth::user()->removeClassFromCart($course_id);
            return redirect()->action('CoursesController@enroll');
        }
        else {
            return redirect()->back();
        }
    }

    public function enrollAll(Request $request) {
        $courses = Auth::user()->cart;
        $errors = [];

        foreach($courses as $course) {
            $results = $course->enroll();

            //if Results contain error message
            if($results) {
                $errors = $results;
                //array_push($errors, ["Section " . $course->class . ": unable to enroll"]);
            }
        }

        return redirect()->action('CoursesController@enroll')
                         ->withErrors($errors);
    }

    public function plan()
    {
        if(Auth::user()->id <= 38)
            return redirect()->route('professors.index');
        else
            return view('students.courses.plan');
    }

    public function enroll(Request $request)
    {
        if(Auth::user()->id <= 38)
            return redirect()->route('professors.index');
        else
            return view('students.courses.enroll');
    }

    public function addCode(Request $request) {
        if(Auth::user()->id <= 38)
            return view('professors.courses.addCode');
        else
            return redirect()->route('students.index');
    }

    public function useaddcode(Request $request) {
        if($request->has('addcode')){
            $code = $request->get('addcode');
            $result = Auth::user()->useAddCode( $code );
            return redirect()->action('CoursesController@enroll')
                             ->with('msg', $result);
        }
        return "Please enter the right addcode";
        


        return redirect()->action('CoursesController@enroll');
    }
}
