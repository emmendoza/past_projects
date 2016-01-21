@extends('base')

@section('navbar-right')
    {!! Form::open(['action' => 'SiteController@login', 'class' => 'form navbar-form navbar-right']) !!}
        <div class="form-group">
            <input name="sjsu_id" type="text" placeholder="SJSU ID" class="form-control input-sm">
        </div>
        <div class="form-group">
            <input name="password" type="password" placeholder="Password" class="form-control input-sm">
        </div>
        <button type="submit" class="btn btn-primary btn-sm">Sign in</button>
    {!! Form::close() !!}
@endsection

@section('main')
    <div class="container">
        <!-- Header Carousel -->
        <div id="myCarousel" class="carousel slide">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div>
                        <img src="/img/1.gif" alt="sjsu" style=" width:1500px" height="350px">
                    </div>

                    <div class="carousel-caption">
                        <h2></h2>
                    </div>
                </div>
                <div class="item">
                    <div>
                        <img src="/img/5.gif" alt="modern sjsu" style=" width:1500px" height="350px">
                    </div>
                    <div class="carousel-caption">
                        <h2></h2>
                    </div>
                </div>
                <div class="item">
                    <div>
                        <img src="/img/3.gif" alt="modern sjsu" style=" width:1500px" height="350px">
                    </div>
                    <div class="carousel-caption">
                        <h2>Spartan</h2>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="icon-prev"></span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="icon-next"></span>
            </a>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12" style="color:#E5A823" style=" background-color:#0D26B4;" >
                <h1 class="page-header" align="center" style="background-color:#0055A2" >
                    Welcome to San Jose State University
                </h1>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#E5A823">
                        <h4><i class="fa fa-fw fa-check"></i> Computer Science Department</h4>
                    </div>
                    <div class="panel-body">
                        <p>The Department of Computer Science strives to provide the highest quality education in Computer Science at the undergraduate and graduate levels. We offer programs that lead to the Bachelor of Science degree (BSCS), and the Master of Science degree (MSCS). </p>
                        <a href="http://www.sjsu.edu/cs/" class="btn btn-default">More info</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#E5A823">
                        <h4><i class="fa fa-fw fa-gift"></i> Math department</h4>
                    </div>
                    <div class="panel-body" >
                        <p>The BA Mathematics is recommended for students who enjoy problem solving and would like to apply problem solving skills along with communication and analyzing skills in a future career. This degree also provides an excellent background for graduate work in mathematics and other disciplines.</p>
                        <a href="http://www.sjsu.edu/math/" class="btn btn-default">More info</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                  <div class="panel-heading" style="background-color:#E5A823">
                        <h4><i class="fa fa-fw fa-compass"></i> Research Foundation</h4>
                    </div>
                    <div class="panel-body">
                      <p>Student and faculty engagement in research, scholarship and creative activity is central to the mission of San José State University. SJSU researchers investigate the airways and sea, space and planets and create partnerships with Silicon Valley's most progressive technology companies.</p>
                      <a href="http://www.sjsu.edu/researchfoundation/" class="btn btn-default">More info</a>
                    </div>
                </div>
            </div>
        </div>
        <!--<button type="submit" class="btn btn-success btn-sm">Sign in</button>-->
        {!! Form::close() !!}
        @if ($errors->has())
            <div style="position:relative;top:10px;background-color:white" class="pull-right text-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        {{--<button type="submit" class="btn btn-success btn-sm">Sign in</button>--}}
        {!! Form::close() !!}
        @if ($errors->has())
            <div style="position:relative;top:10px;background-color:white" class="pull-right text-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection

@section('footer')
    <!-- jQuery -->
    {{--<script src="/js/jquery.js"></script>--}}

    <!-- Bootstrap Core JavaScript -->
    {{--<script src="/js/bootstrap.min.js"></script>--}}

    <!-- Script to Activate the Carousel -->
    <script>
        $('.carousel').carousel({
            interval: 2000 //changes the speed
        })
    </script>

    <div class="footer_1 sjsu-container-prime">
        <footer>
            <div class="container" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="col">
                            <h4>Contact us</h4>
                            <ul>
                                <li><a href="https://www.google.com/maps/@37.3351916,-121.8832602,17z">1 Washington Sq, San Jose, CA 95192</a></li>
                                <li>Phone: 408-924-1000  </li>
                                <li>Email: <a href="mailto:info@example.com" title="Email Us">ithelpdesk@sjsu.edu</a></li>

                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="col">
                            <h4>Colleges</h4>
                            <ul>
                                <li><a href="http://www.sjsu.edu/casa/">Applied Sciences &amp; Arts</a></li>
                                <li><a href="http://www.sjsu.edu/cob/">Business</a></li>
                                <li><a href="http://www.sjsu.edu/education/">Education</a></li>
                                <li><a href="http://engineering.sjsu.edu/">Engineering</a></li>
                                <li><a href="http://www.sjsu.edu/humanitiesandarts/">Humanities &amp; the Arts</a></li>
                                <li><a href="http://www.sjsu.edu/cies/">International &amp; Extended Studies</a></li>
                                <li><a href="http://www.sjsu.edu/science/">Science</a></li>
                                <li><a href="http://www.sjsu.edu/socialsciences/">Social Sciences</a></li>
                            </ul>

                        </div>
                    </div>

                    <div class="col-md-3" >
                        <div class="col col-social-icons">
                            <h4>Follow us</h4>

                            <li><a href="https://www.facebook.com/sanjosestate/">Facebook</a></li>
                            <li><a href="https://plus.google.com/+SJSUBMES/posts">Google +</a></li>
                            <li><a href="https://www.youtube.com/user/sjsu">You Tube</a></li>
                            <li><a href="https://www.linkedin.com/edu/san-jose-state-university-17911">Linkedin</li>
                            <li><a href="https://twitter.com/SJSU?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor">twitter</a></li>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="col">
                            <h4>Quick link</h4>
                            <ul>
                                <li><a target="_blank" href="{{ action('SiteController@cecilia') }}">A-Z Index</a></li>
                                <li><a href="http://www.sjsu.edu/adminfinance/about/budget_central/index.html">Budget Central</a></li>
                                <li><a href="http://www.sjsu.edu/calendars/index.html">Calendars</a></li>
                                <li><a href="https://sjsu.instructure.com/">Canvas</a></li>
                                <li><a href="http://www.sjsu.edu/employment">Careers &amp; Jobs</a></li>
                                <li><a href="http://library.sjsu.edu/"> King Library</a></li>
                                <li><a href="http://www.sjsu.edu/parkingtransportationmaps/index.html">Parking &amp; Maps</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection

