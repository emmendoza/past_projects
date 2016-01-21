@extends('base')

@section('navbar-right')
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="javascript:void(0)" style="color: white;cursor: default;">{{ Auth::user()->name }}</a>
        </li>
        <li>
            <a href="{{ action('SiteController@logout') }}" class="sjsu-secondary" style="color: white;">Sign out</a>
        </li>
    </ul>
@endsection

@section('main')
    <div class="row mysjsu-main-row">
        <div class="col-sm-3">
            <h4 class="lead">Quick Links</h4>
            <hr />
            <ul class="nav nav-pills nav-stacked">
                <li>
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
            <h4 class="lead">
                @if ($errors->has())

                    @foreach ($errors->all() as $error)
                        <p class="alert alert-danger text-center small">
                            {{ $error}}
                        </p>
                    @endforeach

                @endif
                @if (session('msg'))
                    <div class="alert alert-info">
                        {{ session('msg') }}
                    </div>
                @endif
                Spring 2016 Shopping Cart
                    <div class="pull-right">
                        <!--Add Code starts here-->
                        <a href="" class="btn btn-warning" data-toggle="modal" data-target="#myModal">Use Add Code</a>
                        <!--***********************************************
                        ********************** MODAL *******************-->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <center><h3 class = "modal-header" for="ADDcODE">Put add code here and press enter.</h3></center>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                      <input name="addcode" type="text" class="form-control" id="ADDcODE">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ action('CoursesController@useaddcode') }}" id="submitaddcode" class="btn btn-success">Enter</a>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>

                            </div>
                          </div>
                        <!--End of Modal-->
                        <!--Add code ends here;  Enroll All button starts-->
                        <a href="{{action('CoursesController@enrollAll')}}" class="btn btn-success">Enroll All</a>
                    </div>

            </h4>
            <hr />
            @if(Auth::user()->cart->isEmpty())
                <p class="alert alert-info text-center">Your shopping cart is empty.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <td><a href="">Course</a></td>
                        <td><a href="">Instructor</a></td>
                        <td><a href="">Meeting Days & Time</a></td>
                        <td><a href="">Enrolled</a></td>
                        <td><a href="">Waitlist</a></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(Auth::user()->cart as $class)
                        <tr>
                            <td>{{ $class->subject . $class->courseNumber . ' - ' . $class->courseName}}</td>
                            <td>{{ $class->instructor }}</td>
                            <td>{{ $class->meetingTime() }}</td>
                            <td>{{ $class->totalEnrolled() . '/35' }}</td>
                            <td>{{ $class->totalWaitlisted() . '/15' }}</td>
                            <td class="text-center"><a href="{{ action('CoursesController@removeFromCart', ['course_id' => $class->id]) }}">delete</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection


@section('footer')
    @parent
    <script type="text/javascript">
        $('#submitaddcode').click(function() {
            var url = $(this).attr("href");
            var addcode = $('input[name=addcode]').val();

            $(this).attr("href", url + "?addcode=" + addcode);
        });
    </script>
@endsection