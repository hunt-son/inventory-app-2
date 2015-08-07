@extends('layouts.base');


@section('body')
    <h1>Reset Your Password</h1>
    {{Form::open(['route' => 'password_resets.store']) }}

    <div>
    {{Form::label('email', 'Email Address')}}
    {{ Form::text('email', null, ['required' => true] ) }}
    </div>


    <div>
        {{Form::submit('Reset') }}
    </div>

    @if (Session::has('error'))
            {{Session::get('reason')}}

    @elseif (Session::has('success'))
        <p>Please check your email!</p>
    @endif
@stop