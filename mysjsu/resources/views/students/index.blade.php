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
                    <a href="{{ action('StudentsController@index') }}">
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

            <div>
               <script type="text/javascript" src="{{ URL::asset('js/jquery-2.1.4.min.js') }}"></script>
                    <script type="text/javascript" src="{{ URL::asset('js/Chart.min.js') }}"></script>

                    <img src="/img/chart.gif" alt="sjsu" style=" width:250px" height="70px">
                    <br><br>
               
                   <canvas id="mycanvas" width="256" height="256">
                        <script>

                                var data;

                                $.ajax("{{ action('APIController@main', ['data' => 'classestaken'])}}", {
                                    success: function(ret) {
                                        data = ret;
                                    },
                                    async: false
                                });

                                var Class_Taken = [];
                                for(var i = 0; i < data.length; i++) {
                                    (function() {
                                        var obj = data[i];
                                        Class_Taken.push(obj.subjectNumber);
                                        console.log(obj.subjectNumber);
                                    })();
                                }

                                console.log(Class_Taken.length);

                                var CS_MUST_count = 0;
                                var MATH_MUST_count = 0
                                var CS_ELECTIVE_count = 0;

                                var math = 50;
                                var cs = 40;
                                var left = 10;
                                var left_Math = 0;
                                var left_CS = 0;

                                var elective_classes = 7;

                                var CS_MUST = ["CS 46A", "CS 46B", "CS 47","CS 100W","CS 146","CS 147","CS 149","CS 151","CS 152","CS 154","CS 160"];
                                var MATH_MUST = ["MATH 30", "MATH 31","MATH 32","MATH 42","MATH 129"];
                                
                                var CS_ELECTIVE = ["CS 72","CS 108","CS 116A","CS 116B","CS 122","CS 120A","CS 120B","CS 134","CS 143C","CS 157A","CS 157B","CS 159","CS 174","CS 180H","CS 185C"];
                               
                                // var Class_Taken = ["CS 152", "CS 146", "CS 149","MATH 129","CS 46B","MATH 31","CS 100W"]

                                var Total_requirment = CS_MUST.length + MATH_MUST.length + elective_classes;

                                for(var i = 0; i < Class_Taken.length ; i++ ) {

                                        for(var j = 0; j < CS_MUST.length ; j++ ) {

                                            if(Class_Taken[i] == CS_MUST[j]) {

                                                CS_MUST_count++;
                                            }
                                        }
                                }

                                for(var i = 0; i < Class_Taken.length ; i++ ) {

                                        for(var j = 0; j < MATH_MUST.length ; j++ ) {

                                            if(Class_Taken[i] == MATH_MUST[j]) {

                                                MATH_MUST_count++;
                                            }
                                        }
                                }

                                for(var i = 0; i < Class_Taken.length ; i++ ) {

                                        for(var j = 0; j < CS_ELECTIVE.length ; j++ ) {

                                            if(Class_Taken[i] == CS_ELECTIVE[j]) {

                                                CS_ELECTIVE_count++;
                                            }
                                        }
                                }

                                if(CS_ELECTIVE_count > 7) {

                                    CS_ELECTIVE_count = 7;
                                } 

                                cs = CS_MUST_count + CS_ELECTIVE_count;

                                math = MATH_MUST_count;

                                left_Math = MATH_MUST.length - MATH_MUST_count;

                                left_CS = CS_MUST.length + CS_ELECTIVE.length - cs;

                                //left = Total_requirment - cs - math;


                            $(document).ready(function(){
                                var ctx = $("#mycanvas").get(0).getContext("2d");

                                var data = [
                                    {
                                        value: math,
                                        color: "cornflowerblue",
                                        highlight: "lightskyblue",
                                        label: "Math complete",


                                    },
                                    {
                                        value: cs,
                                        color: "lightgreen",
                                        highlight: "yellowgreen",
                                        label: "CS complete"

                                    },
                                    {
                                        value: left_CS,
                                        color: "orange",
                                        highlight: "darkorange",
                                        label: "CS Left"

                                    },
                                    {
                                        value: left_Math,
                                        color: "Green",
                                        highlight: "darkgreen",
                                        label: "Math Left"
                                    }
                                ];

                                //draw
                                var piechart = new Chart(ctx).Pie(data);
                            });
                        </script>
            
            </div>

        </div>
        <div class="col-sm-9">
            {{--<h4 class="lead">Alerts</h4>--}}
            {{--<hr />--}}
            {{--<p class="alert alert-info text-center">You have no alert</p>--}}
            {{--<br />--}}

            <h4 class="lead">Courses I'm Taking</h4>
            <hr />
            @if(Auth::user()->currentClasses())
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>
                                <a href="javascript:void(0)">Course</a>
                            </td>
                            <td>
                                <a href="javascript:void(0)">Professor</a>
                            </td>
                            <td>
                                <a href="javascript:void(0)">Room</a>
                            </td>
                            <td>
                                <a href="javascript:void(0)">Semester</a>
                            </td>
                            <td>
                                <a href="javascript:void(0)">Meeting Days & Time</a>
                            </td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach(Auth::user()->currentClasses() as $class)
                        @if($class["grade"][0] === "-")
                            <tr class="default">
                                @elseif($class["grade"][0] === "A")
                            <tr class="success">
                                @elseif($class["grade"][0] === "B")
                            <tr class="info">
                                @elseif($class["grade"][0] === "C")
                            <tr class="warning">
                        @else
                            <tr class="danger">
                        @endif
                                <td>
                                    {{$class["subjectNumber"]}}
                                    @if(Auth::user()->waitlist($class["class"]))
                                        <i class="glyphicon glyphicon-warning-sign text-warning"></i>
                                    @endif
                                </td>
                                <td>{{$class["instructor"]}}</td>
                                <td>{{$class["room"]}}</td>
                                <td>{{$class["semester"] . ' ' . $class["year"]}}</td>
                                <td>{{$class["meetingTime"]}}</td>
                                <td><a href="{{ action('CoursesController@dropClass', ['student_id' => Auth::user()->id, 'section_id' => $class["section_id"]]) }}">drop</a></td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info text-center">You are not currently taking any classes</p>
            @endif

            <br/>

            <h4 class="lead">Courses I've Taken</h4>
            <hr />
            @if(Auth::user()->pastClasses())
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Course</th>
                        <th>Course Name</th>
                        <th>Semester</th>
                        <th>Grade Received</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Auth::user()->pastClasses() as $class)
                        @if($class["grade"][0] === "-")
                        <tr class="default">
                        @elseif($class["grade"][0] === "A")
                        <tr class="success">
                        @elseif($class["grade"][0] === "B")
                        <tr class="info">
                        @elseif($class["grade"][0] === "C")
                        <tr class="warning">
                        @else
                        <tr class="danger">
                        @endif
                            <td>{{$class["subjectNumber"]}}</td>
                            <td>{{$class["courseName"]}}</td>
                            <td>{{$class["semester"] . ' ' . $class["year"]}}</td>
                            <td>{{$class["grade"]}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info text-center">You have not previously taken any courses yet</p>
            @endif
            {{--<a href=""><p class="text-right">more</p></a>--}}


            {{--<h4 class="lead">Student Balance</h4>--}}
            {{--<hr />--}}
            {{--<p class="alert alert-info text-center">You have no outstanding balance</p>--}}
        </div>
    </div>
@endsection