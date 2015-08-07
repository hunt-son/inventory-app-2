

@section('body')
{{HTML::style('/CSS/users.css') }}


<!-- prevents display on refresh messages -->
@if (! isset($count))
    <?php $count=0 ?>
@endif
    @if (Session::has('flash_notification.message') and $count == 0)
        <div class="alert alert-error" style="text-align: center">
            {{ Session::get('flash_notification.message') }}
        </div>
       {{$count = null}}
    @endif

{{ Form::open(array('route' => 'sessions.store')) }}


<h1>Please Log In</h1>
<input placeholder="Username" type="text" required="" name="username">
<input placeholder="Password" type="password" required="" name="password">

<button class="submit">Submit</button>
<div style="text-align:center; margin-top:10px;">
    {{ link_to_route('password_resets.create', 'Forgot your Password?') }}
</div>
{{ Form::close() }}

<link href='http://fonts.googleapis.com/css?family=Roboto:400' rel='stylesheet' type='text/css'>
