<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'SiteController@index');
Route::post('login', 'SiteController@login');
Route::get('logout', 'SiteController@logout');

Route::get('students/academics', 'StudentsController@academics');
Route::resource('students', 'StudentsController');
Route::resource('professors', 'ProfessorsController');
Route::get('courses/dropclass', 'CoursesController@dropClass');
Route::get('courses/addtocart', 'CoursesController@addToCart');
Route::get('courses/removefromcart', 'CoursesController@removeFromCart');
Route::get('courses/enrollall', 'CoursesController@enrollAll');
Route::get('courses/enroll', 'CoursesController@enroll');
Route::get('courses/plan', 'CoursesController@plan');
Route::get('courses/addcode', 'CoursesController@addCode');
Route::get('courses/useaddcode', 'CoursesController@useaddcode');
Route::resource('courses', 'CoursesController');

/* API */
Route::get('api', 'APIController@main');

/*
 * Temporary Routes
 */
Route::get('cecilia', 'SiteController@cecilia');
Route::get('maninderpal', 'SiteController@maninderpal');

/*
 * Redirect routes
 */
Route::get('auth/login', function() {
   return redirect()->action('SiteController@index');
});
