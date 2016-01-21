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
                    <a href="{{ action('ProfessorsController@index') }}">
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
                    <a href="{{ action('CoursesController@addCode') }}">
                        <i class="glyphicon glyphicon-list-alt"></i>
                        Add Codes
                    </a>
                </li>
            </ul>
            <hr />
        </div>
        <div class="col-sm-9">
            <h4 class="lead">Genrate Add Code</h4>
            <hr />
                @foreach (Auth::user()->classesTaught() as $class)
                    <table  class="col-md-12 table table-bordered table-striped">
                    <thead>
                    <tr class = "">
                        <th class ="col-md-3">Course</th>
                        <th class ="col-md-3">Course Name</th>
                        <th class ="col-md-3">
                            Issued Add Codes
                        </th>
                        <th class ="col-md-3"> Action </th>
                    </tr>
                <tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$class["subject"]. " " . $class["courseNumber"] . " - " . $class["class"]}}</td>
                        <td>{{$class["courseName"]}}</td>
                        <td>
                            @foreach(Auth::user()->returnActiveCodes($class["class"]) as $code)
                                {{ $code->code }} <br />
                            @endforeach
                        </td>
                        <td>
                            <a class="btn btn-sm btn-success"
                               href="{{ action('APIController@main', ['data'=>'generateaddcode', 'section_id' => $class["class"]]) }}">
                                Issue Add Code
                            </a>
                        </td>
                    </tr>
            </table>
               @endforeach 
           
        </div>
    </div>
@endsection

@section('footer')
    @parent
    <script type="text/javascript">
        function generateAddCode(section_id) {
            var url = '{{ action('APIController@main') }}' + '?data=generateaddcode&section_id' + section_id;
            $.ajax(url, {
                success: function(data) {
                    alert(data);
                },
                error: function(data) {
                    alert(JSON.stringify(data));
                }
            });
            return false;
        }
    </script>
@endsection