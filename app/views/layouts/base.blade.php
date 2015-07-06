<!DOCTYPE HTML>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <head>
            <title>INVENTORY APP</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
            <link rel="stylesheet" href="https:////cdn.datatables.net/1.10.7/css/jquery.dataTables.css">

            {{HTML::style('/CSS/application.css') }}
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
            <script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
            <script src=" http://appelsiini.net/download/jquery.jeditable.mini.js"></script>
            <script src="http://code.highcharts.com/highcharts.js"></script>
        </head>

<body>
    <div class="container">
        @include('layouts.navigation')
        @yield('body')
    </div>

    <footer>@yield('footer')</footer>
</body>



</html>