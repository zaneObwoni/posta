<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="ThemeBucket" name="author">
    <meta content="”IE=EmulateIE9”" http-equiv="”X-UA-Compatible”">
    <meta content="”IE=9”" http-equiv="”X-UA-Compatible”">
    <link href="images/favicon.png" rel="shortcut icon">
    <title>
        {{ app_name() }}
    </title><!--Core CSS -->
    <link href="/bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/js/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet">
    <link href="/css/bootstrap-reset.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/js/jvector-map/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <link href="/css/clndr.css" rel="stylesheet"><!--clock css-->
    <link href="/js/css3clock/css/style.css" rel="stylesheet">
    <!--Morris Chart CSS -->
    <link href="/js/morris-chart/morris.css" rel="stylesheet">
    <link href="/css/adjust.css" rel="stylesheet">
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

    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>

    @yield('css')

    <style type="text/css">
        body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                color:#000;
                /**font-weight: 100;
                font-family: 'Lato', sans-serif;*/
                font-family: 'Arial';
            }
    </style>
</head>

<body>

    @yield('content')

    @yield('js')
</body>
</html>