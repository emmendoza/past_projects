@extends('base')

@section('navbar-right')
    <ul class="nav navbar-nav navbar-right">
        <li><a href="" style="color: white">John Doe | Sign out</a></li>
    </ul>
@endsection

@section('main')
    <div class="row mysjsu-main-row">
        <div class="col-sm-3">
            <h4 class="lead">Quick Links</h4>
            <hr />
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <a href="{{ action('CoursesController@index') }}">
                        <i class="glyphicon glyphicon-search"></i>
                        Search Classes
                    </a>
                </li>
                <li>
                    <a href="{{ action('CoursesController@plan') }}">
                        <i class="glyphicon glyphicon-edit"></i>
                        Plan
                    </a>
                </li>
                <li class="active">
                    <a href="{{ action('CoursesController@enroll') }}">
                        <i class="glyphicon glyphicon-list-alt"></i>
                        Enroll
                    </a>
                </li>
                <li>
                    <a href="{{ action('StudentsController@academics') }}">
                        <i class="glyphicon glyphicon-education"></i>
                        Academics
                    </a>
                </li>
            </ul>
            <hr />
        </div>
        <div class="col-sm-9">
            <br />
            <br />
            <br />
 <h4 class="lead">Spring 2016 Shopping Cart</h4>
            <hr />
            <table class="table">
                <thead>
                <tr>
                    <th>Course</th>
                    <th>Course Name</th>
                    <th>Instructor</th>
                    <th>Grade Received</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>CS 49J</td>
                    <td>Introduction to Java</td>
                    <td>Frank Butt</td>
                    <td>A+</td>
                </tr>
                <tr>
                    <td>CS 46B</td>
                    <td>Introduction to CS Part II</td>
                    <td>Frank Butt</td>
                    <td>A+</td>
                </tr>
                <tr>
                    <td>CS 49C</td>
                    <td>Introduction to C Programming</td>
                    <td>Frank Butt</td>
                    <td>C</td>
                </tr>
                <tr>
                    <td>CS 46A</td>
                    <td>Introduction to CS Part I</td>
                    <td>Frank Butt</td>
                    <td>F</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection