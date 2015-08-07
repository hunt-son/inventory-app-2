<?php if(! Auth::check()) { Route::get('/', 'SessionsController@create'); }?>

<!DOCTYPE HTML>
<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <head>
            <title>INVENTORY APP</title>
            {{HTML::style('/CSS/application.css') }}
            {{HTML::style('/CSS/bootstrap.min.css') }}
            {{HTML::style('/CSS/bootstrap-theme.min.css') }}

            {{HTML::style('/CSS/bootstrap-select.css') }}
            {{HTML::style('/CSS/jquery.dataTables.min.css') }}

            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
            {{HTML::script('/JS/bootstrap.min.js') }}
            {{HTML::script('/JS/bootstrap-select.js') }}
            {{HTML::script('/JS/jquery.dataTables.min.js') }}
            <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

        </head>

<body>
    <div class="background-top">
    </div>

@if (! isset($count))
    <?php $count=0 ?>
@endif
@if (Session::has('flash_notification.message') and $count == 0)
    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        {{ Session::get('flash_notification.message') }}
    </div>
    {{$count = null}}
@endif

    <div class="container">
        @include('layouts.navigation')
        @yield('body')
    </div>

    <footer>@yield('footer')</footer>
    <div class="background-bottom">
    </div>
</body>



</html>