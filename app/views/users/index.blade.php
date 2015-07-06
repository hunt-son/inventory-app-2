{{HTML::style('/CSS/users.css') }}
{{ Form::open(array('route' => 'users.store')) }}


<h1>Please Log In</h1>
<input placeholder="Username" type="text" required="" name="username">
<input placeholder="Password" type="password" required="" name="password">
<button>Submit</button>
    {{ Form::close() }}

<link href='http://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>