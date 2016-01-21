<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />

</head>
@extends('base')

@section('navbar-right')
    @if(Auth::check())
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="javascript:void(0)" style="color: white;cursor: default;">{{ Auth::user()->name }}</a>
            </li>
            <li>
                <a href="{{ action('SiteController@logout') }}" class="sjsu-secondary" style="color: white;">Sign out</a>
            </li>
        </ul>
    @endif
@endsection

@section('main')
    <div class="row mysjsu-main-row">
        <div class="col-sm-3">
            <h4 class="lead">Quick Links</h4>
            <hr />
            <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="">
                        <i class="glyphicon glyphicon-home"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ action('CoursesController@index') }}">
                        <i class="glyphicon glyphicon-search"></i>
                        Search Classes
                    </a>
                </li>
                <li>
                    <a href="{{ action('CoursesController@addCode') }}">
                        <i class="glyphicon glyphicon-list-alt"></i>
                        Add Codes
                    </a>
                </li>
            </ul>
            <hr />
        </div>
        <div class="col-sm-9">
            {{--<h4 class="lead">Alerts</h4>--}}
            {{--<hr />--}}
            {{--<p class="text-center">There is a problem student in CS 49J Enrolled.</p>--}}
            {{--<br />--}}

            <!--<a href="{{ action('CoursesController@show', 1) }}">link</a>-->
            <h4 class="lead">Courses I'm Teaching</h4>
            <hr />

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Course</th>
                    <th>Course Name</th>
                    <th>Status</th>
                    <th>View Enrolled</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Auth::user()->classesTaught() as $class)
                    <tr>
                        <td>{{ $class->subject . ' ' . $class->courseNumber }}</td>
                        <td>{{ $class->courseName }}</td>
                        <td>
                            <div class="accordion-inner">
                                Enrolled: {{ $class->totalEnrolled() }} <br>
                                Waitlist: {{ $class->totalWaitlisted() }} <br>
                            </div>
                        </td>
                        <td> <a href="{{ action('CoursesController@show', $class->id) }}">More Info</a> </td>
                    </tr>
                @endforeach
                </tbody>
            </table> 
            {{--<a href=""><p class="text-right">more</p></a>--}}
            <br />
        </div>
    </div>

<!-- JAVASCRIPT -->
            <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.23/angular.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/angular-filter/0.5.4/angular-filter.min.js"></script>
@endsection