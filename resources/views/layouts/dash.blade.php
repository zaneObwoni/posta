<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="ThemeBucket" name="author">
    <meta content="”IE=EmulateIE9”" http-equiv="”X-UA-Compatible”">
    <meta content="”IE=9”" http-equiv="”X-UA-Compatible”">
    <link href="/images/favicon.png" rel="shortcut icon">
    <title>
        {{ app_name() }}
    </title>

    <!--Core CSS -->
    <link href="/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="/css/bootstrap-reset.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="/css/clndr.css" rel="stylesheet"><!--clock css-->
    <link href="/js/css3clock/css/style.css" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link href="/js/morris-chart/morris.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/style-responsive.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script> -->

    @yield('css')

    <style type="text/css">

        * {
            margin: 0;
        }
        html, body{
            height:100%;
        }
        .page-wrap{
            min-height: 100%;
            margin-bottom: -142px;
        }

        .page-wrap:after{

            content:"";
            display: block;
        }

        .site-footer, .page-wrap:after{

            height: 142px;
        }

        .site-footer{
            /*position: absolute;*/
            bottom: 0;
            width: 100%;
            margin:0 auto;
            /*background: orange;*/
        }

        .ads{
            background: #fff;
            float: right;
        }

        .li-st{
            color:#fff;
            margin-top: 0%;
            padding-left: 5%;

            color: #fff;
            font-size: 16px;
            background: none;
            padding: 4px 8px;
            /*margin-right: 15px;*/
            /*border-radius: 50%;*/
            /*-webkit-border-radius: 50%;*/
            /*padding-right: 8px !important;*/
        }
    </style>
</head>
<body>

    <div class="page-wrap">
        <section id="container">
            <!--header start-->
            <header class="header fixed-top clearfix" style="background-color:#1896d7">
                <!--logo start-->
                <div class="brand" style="background-color:#fff; border:solid 1px #ccc;">
                    <a class="logo" href="{!! route('user.dashboard') !!}">
                        <img alt="" src="/images/logo.png" width="70%">

                    </a>
                    <!-- <div class="sidebar-toggle-box">
                        <div class="fa fa-bars"></div>
                    </div> -->
                </div><!--logo end-->

                <!-- Notification Start -->
                <div class="nav notify-row" id="top_menu" style=" max-width: 700px;">
                    <!--  notification start -->
                    <ul class="nav top-menu">

                        <!-- <li>FAQs</li> -->
                        <!-- notification dropdown start-->
                        <li id="header_notification_bar" class="dropdown" style="background:#f6f6f6; border-radius:50%;">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                                <i class="fa fa-bell-o"></i>
                                @if($notifications_count >= 1)
                                <span class="badge bg-warning">{!! $notifications_count !!}</span>
                                @else
                                <span></span>
                                @endif
                            </a>

                            <ul class="dropdown-menu extended notification" style="height:400px; overflow-y:scroll;">
                                <li>
                                    <p>Notifications</p>
                                </li>

                                @if($notifications->count())
                                    @foreach($notifications as $notification)
                                        <li>
                                            <div class="alert alert-info clearfix">
                                                <span class="alert-icon"><i class="fa fa-bolt"></i></span>
                                                <div class="noti-info">
                                                    <a href="{!! route('notifications.show', $notification->id) !!}">{!! $notification->title !!}</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                        <!-- notification dropdown end -->
                        <li class="li-st" style="background:#1896D7;">
                            <a href="{!! route('coming') !!}" style="color:#fff" target="_blank">
                                FAQs
                            </a>
                        </li>
                        <li class="li-st">
                            <a href="{!! route('emails.care.create') !!}" style="color:#fff">
                                Feedback
                            </a>
                        </li>
                        <li class="li-st">
                            <a href="{!! route('coming') !!}" style="color:#fff" target="_blank">
                                Help
                            </a>
                        </li>
                        <li class="li-st">
                            <a href="/logout" style="color:#fff">
                                Log Out :  {!! $user->email !!}
                            </a>
                        </li>
                    </ul>
                    <!--  notification end -->
                </div>
                <!-- Notification End -->


                <div class="top-nav clearfix">

                    <!--search & user info start-->
                    <ul class="nav pull-right top-menu">
                        <li style="background:none; margin-top:3%;">
                            <a href="#" style="color:#000">Chat</a>
                        </li>
                        
                        <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <img alt="" src="/uploads/user/{!! $user->pic !!}">

                                <span class="username">{!! $user->first_name." " !!}</span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <li>
                                    <a href="{!! route('user.profile') !!}">
                                        <i class="fa fa-suitcase"></i>
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! route('user.edit', $user->id) !!}">
                                        <i class="fa fa-cog"></i>
                                        Settings
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! route('user.surrender', $user->id) !!}">
                                        <i class="fa fa-lock"></i>
                                        Surrender Box
                                    </a>
                                </li>
                                <li>
                                    <a href="/logout">
                                        <i class="fa fa-key"></i>
                                        Log Out
                                    </a>
                                </li>
                            </ul>
                        </li><!-- user login dropdown end -->

                    </ul><!--search & user info end-->
                </div>
            </header>
            <!--header end-->

            <!--sidebar start-->
            @include('partials.backend.sidebar')
            <!--sidebar end-->

            @yield('content')

        </section>
    </div>

    <!--footer start-->
    <footer class="site-footer">
        <!-- <div style="margin-left:30%">
            <img src="/images/postbank-600.png">
        </div> -->

        <div class="text-center" style="padding-top:1%">
            2016 &copy; Postal Corporation of Kenya. For more Information visit <a href="http://posta.co.ke" style="color:#1896D7;" target="_blank">www.posta.co.ke</a>
            <div class="pull-right">
                Powered by
                <a href="http://simpay.co.ke" target="_blank">
                    <img src="/images/simpay-70.png">
                </a>
            </div>
        </div>
    </footer>
    <!--footer end-->

    @yield('js')
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" /> -->
    <!-- <script src="/js/jquery.js" /> -->
</body>
</html>
