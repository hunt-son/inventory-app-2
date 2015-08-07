<script src="/JS/inventory.js" xmlns="http://www.w3.org/1999/html"></script>


<nav class="navbar navbar-default">
    <div class="container-fluid container">
        <!-- Brand and toggle get grouped for better mobile display -->

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <a class="navbar-brand" href=""><img class="makeSmaller" src="http://cdn.mysitemyway.com/etc-mysitemyway/icons/legacy-previews/icons/retro-green-floral-icons-alphanumeric/073915-retro-green-floral-icon-alphanumeric-bracket-curley.png"></a>
            <ul class="nav navbar-nav">
                <li class="active-nav"><a href="/">Products <span class="sr-only">(current)</span></a></li>
                <li><a href="/daily">Daily Log</a></li>
                @if (Auth::check())
                    @if(Auth::getUser()->hasRole('Owner'))
                    <li><a href="/users">Manage Users</a></li>
                    @endif
                @endif
            </ul>
<ul class="nav navbar-nav navbar-right">
    <li><a href="/?forms" id="showAvailableForms">Forms</a></li>

    <li><a href="/logout">Logout</a></li>
</ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
