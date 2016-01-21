<?php

namespace App\Http\Controllers;

use App\Instructor;
use App\Professor;
use App\Student;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function index() {
        if(Auth::check()) {
            if(Auth::user()->isProfessor())
                return redirect()->action('ProfessorsController@index');
            else
                return redirect()->action('StudentsController@index');
        }
        else {
            return view('login');
        }
    }

    public function login(Request $request) {
        if(Auth::check() == false) {
            $id = $request->get('sjsu_id');
            $password = $request->get('password');
            $inputs = ['id' => $id, 'password' => $password];
            $rules = ['id'    => 'required', 'password' => 'required',];
            $validator = Validator::make($inputs, $rules);
            $user = User::find($id);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->except('password'));
            }


            if($user && $password === $user->password) {
                Auth::login($user);

                if($id <= 38) {
                    return redirect()->action('ProfessorsController@index');
                }
                else {
                    return redirect()->action('StudentsController@index');
                }
            }

            return redirect()->back();
        }
        else {
            return redirect()->back();
        }
    }

    public function logout() {
        if(Auth::check()) {
            Auth::logout();
            return redirect()->action('SiteController@index');
        }
        else {
            return redirect()->back();
        }
    }

    public function cecilia() {
        return view('cecilia/temp');
    }

    public function maninderpal() {
        return view('maninderpal/temp');
    }

    private function verify($request, $id, $password)
    {
        $inputs = ['id' => $id, 'password' => $password];
        $rules = [
            'id'    => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($inputs, $rules);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator) // send back all errors to the login form
                             ->withInput($request->except('password')); // send back the input (not the password) so that we can repopulate the form
        }
        else {
            $id = (isset($inputs['id']) ? $inputs['id'] : '');
            $password = (isset($inputs['password']) ? $inputs['password'] : '');

            if (Auth::attempt(['id' => $id, 'password' => $password], false, true)) {
                return redirect()->route('students.index');
            }
            else {
                return "wrong credential: " . $id . " " . $password;
//                return redirect()->back()
//                    ->withErrors('Login credentials are not correct, please try again.')
//                    ->withInput($request->except('password'));
            }
        }
    }
}
