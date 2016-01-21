<!DOCTYPE html>
<html>
    <!--**********************************************************************************************
    *******************************D A S H B O A R D   P A G E ***************************************
    ***********************************************************************************************-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">

        <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/css/style-responsive.css') }}" rel="stylesheet" type="text/css" />
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    
    <script type="text/javascript" src="{{ URL::asset('js/Chart.min.js') }}"></script>
    </head>

    <body>

    <section id="container" >
        <!--header-->
        <header class="header black-bg">
            <!--title start-->
            <a href="index.html" class="title"><b>MySJSU</b></a>
            <!--title end-->
            <div class="top-menu">
                <!--careless whisper-->
                <!--shhh...-->
                <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="login.html">Logout</a></li>
                </ul>
            </div>
        </header>
        <!--header end-->

        <!--**********************************************************************************************
        ******************************************* S I D E B A R ***************************************
        ***********************************************************************************************-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">

                   <center><img src="https://upload.wikimedia.org/wikipedia/en/thumb/2/27/San_Jose_State_Spartans_Logo.svg/325px-San_Jose_State_Spartans_Logo.svg.png" style="width:30%; height:30%;"></center>
                    <h5 class="centered">
                        Welcome, <br><br>
                        [[Student.name]]</h5>

                    <li class="mt">
                        <a href="{{ action('StudentsController@index') }}">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="{{ action('CoursesController@index') }}" >
                            <i class=""></i>
                            <span>Search Classes</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="{{ action('CoursesController@plan') }}" >
                            <i class=""></i>
                            <span>Plan</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="{{ action('CoursesController@enroll') }}" >
                            <i class=""></i>
                            <span>Enroll</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="{{ action('StudentsController@academics') }}" >
                            <i class=""></i>
                            <span>My Academics</span>
                        </a>
                    </li>
                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        <!--**********************************************************************************************
        *******************************M I D D L E   S E C T I O N ***************************************
        ***********************************************************************************************-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                    <div class="col-lg-9 main-chart"  style="padding-top: 20px;">
                        <!--***********************************************************************************
                **************************START  OF NG FILTER********************************************
                *************************************************************************************-->           
                <div ng-app="main" ng-controller="mainController">

                  <div class="alert alert-info">
                    <p>Sort Type: [[ sortType ]]</p>
                    <p>Sort Reverse: [[ sortReverse ]]</p>
                    <p>Search Query: [[ searchClass ]]</p>
                  </div>

                  <form>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-search"></i></div>
                        <input type="text" class="form-control" placeholder="Search for ya classes" ng-model="searchClass">
                      </div>      
                    </div>
                  </form>

                  <table class="table table-bordered table-striped">

                    <thead>
                      <tr>
                        <td>
                          <a href="#" ng-click="sortType = 'courseid'; sortReverse = !sortReverse">
                            Course ID
                            <span ng-show="sortType == 'courseid' && !sortReverse" class="fa fa-caret-down"></span>
                            <span ng-show="sortType == 'courseid' && sortReverse" class="fa fa-caret-up"></span>
                          </a>
                        </td>
                        <td>
                          <a href="#" ng-click="sortType = 'coursename'; sortReverse = !sortReverse">
                          Course Name 
                            <span ng-show="sortType == 'coursename' && !sortReverse" class="fa fa-caret-down"></span>
                            <span ng-show="sortType == 'coursename' && sortReverse" class="fa fa-caret-up"></span>
                          </a>
                        </td>
                        <td>
                          <a href="#" ng-click="sortType = 'professor'; sortReverse = !sortReverse">
                          Professor 
                            <span ng-show="sortType == 'professor' && !sortReverse" class="fa fa-caret-down"></span>
                            <span ng-show="sortType == 'professor' && sortReverse" class="fa fa-caret-up"></span>
                          </a>
                        </td>
                        <td>
                          <a href="#" ng-click="sortType = 'room'; sortReverse = !sortReverse">
                            Room Number and Time
                            <span ng-show="sortType == 'room' && !sortReverse" class="fa fa-caret-down"></span>
                            <span ng-show="sortType == 'room' && sortReverse" class="fa fa-caret-up"></span>
                          </a>
                        </td>
                      </tr>
                    </thead>

                    <tbody>
                      <tr ng-repeat="roll in class | orderBy:sortType:sortReverse | filter:searchClass">
                        <td>[[ roll.courseid ]]</td>
                        <td>[[ roll.coursename ]]</td>
                        <td>[[ roll.professor ]]</td>
                        <td>[[ roll.room ]]</td>
                      </tr>
                    </tbody>

                  </table>

                </div> 

                    <script>
                    angular.module('main', [])
                    .config(function ($interpolateProvider) {
                        $interpolateProvider.startSymbol('[[');
                        $interpolateProvider.endSymbol(']]');
                    })
                    .controller('mainController', function($scope) {
                      $scope.sortType     = 'courseid'; // set the default sort type
                      $scope.sortReverse  = false;  // set the default sort order
                      $scope.searchClass   = '';     // set the default search/filter term

                      // create the list of class rolls 
                      $scope.class = [
                        { courseid: '10000', coursename: 'CS46A', professor: 'O-Brien',room:'WSQ 109' },
                        { courseid: '20000', coursename: 'CS46B', professor: 'Potika', room:'MQH 233' },
                        { courseid: '30000', coursename: 'CS151', professor: 'Ezzat',room:'MQH 225' },
                        { courseid: '40000', coursename: 'CS151', professor: 'Kim',room:'MQH 345' },
                        { courseid: '50000', coursename: 'CS174', professor: 'Kim',room:'MQH 345' },
                        { courseid: '60000', coursename: 'CS160', professor: 'Kim',room:'MQH 345' },
                        { courseid: '70000', coursename: 'CS187', professor: 'Badari',room:'WSQ 109' },
                        { courseid: '80000', coursename: 'CS174', professor: 'Butt', room:'MQH 233' },
                        { courseid: '90000', coursename: 'CS232', professor: 'Austin',room:'MQH 225' },
                        { courseid: 'abcde', coursename: 'CS134', professor: 'Finder',room:'MQH 345' },
                        { courseid: 'edcba', coursename: 'CS161', professor: 'Ezzat',room:'MQH 345' },
                        { courseid: 'zywxv', coursename: 'CS151', professor: 'Lynn',room:'MQH 345' }
                      ];
                    });
                </script>        

                    <!--***********************************************************************************
                    **************************END OF NG FILTER********************************************
                    *************************************************************************************-->
                        
                        <h1>CURRENT CLASSES</h1>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Section</th>
                                <th>Class</th>
                                <th>Room</th>
                                <th>Time</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>CS 174</td>
                                <td>MQH 232</td>
                                <td>6:00 - 7:15 AM</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>CS 151</td>
                                <td>MQH 232</td>
                                <td>6:00 - 7:15 AM</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>CS 157B</td>
                                <td>MQH 232</td>
                                <td>6:00 - 7:15 AM</td>
                            </tr>
                            </tbody>
                        </table>
                    </div><!-- /col-lg-9 END SECTION MIDDLE -->

            <!--**********************************************************************************************
            *******************************R I G H T   S I D E B A R ***************************************
            ***********************************************************************************************-->

                    <div class="col-lg-3 ds">
                        <!-- PUT WHATEVER YA WANT HERE -->
                        <h3>NOTIFICATIONS</h3>
                        <br><br>
                        
                        <!--<div class="col-lg-6">-->
                          <div class="content-panel">
							  <h4><i class="fa fa-angle-right"></i> GPA Chart</h4>
                              <div class="panel-body text-center">
                                  <canvas id="line" height="300" width="200"></canvas>
                              </div>
                          </div>
                        <!--</div>-->
                        
                        My fake plants died because I did not pretend to water them.
                        <br><br><br>
                    </div><!-- /col-lg-3 -->
                </div><!--/row -->
            </section>
        </section>
        <!--main content end-->

        <!--footer start-->
        <footer class="site-footer">
            <div class="text-center">
                (c) SJSU
            </div>
        </footer>
        <!--footer end-->
    </section>

    <!-- ******************* JAVASCRIPT ****************** -->
    <script>  
    var Script = function () {
        var lineChartData = {
            labels : ["Sem 1","Sem 2","Sem 3","Sem 4","Sem 5","Sem 6","Sem 7"],
            datasets : [
                {
                    data : [3.5,4.0,4.0,3.5,3.75,3.2,4.0],
                    fillColor : "rgba(151,187,205,0.5)",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "rgba(151,187,205,1)",
                    pointStrokeColor : "#fff"
                }
            ]

        };
         new Chart(document.getElementById("line").getContext("2d")).Line(lineChartData);
        }();
    </script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    <!-- ************** END OF JAVASCRIPT *************** -->
    
    </body>
</html>
