@extends('front.layouts.simple')
@section('title', __('app.login'))

@section('content')

{!! Form::open(['method' => 'POST', 'url' => route('login'), 'class' => 'form-login']) !!}
<div class="text-center mb-4">
    <h1 class="h3 mb-3 font-weight-normal"><a href="{{ route('home') }}">{{ config('app.name') }}</a></h1>
</div>
@if ($errors->count())
    <div class="alert alert-warning">{!! implode('<br>', $errors->all()) !!}</div>
@endif
<div class="form-label-group">
    {!! Form::text('email', null, [
        'id' => 'inputEmail',
        'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
        'placeholder' => __('app.email_or_user_name'),
        'required',
        'autofocus',
    ]) !!}
    
    {!! Form::label('inputEmail', __('app.email_or_user_name')) !!}
</div>
<div class="form-label-group">
    {!! Form::password('password', [
        'id' => 'inputPassword',
        'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
        'placeholder' => __('app.password'),
        'required',
    ]) !!}
    
    {!! Form::label('inputPassword', __('app.password')) !!}
</div>

<div class="checkbox mb-3">
    <label>
        {!! Form::checkbox('remember', 1, false) !!} @lang('app.remember_me')
    </label>
</div>
{!! Form::submit(__('app.login'), ['class' => 'btn btn-lg btn-primary btn-block']) !!}
<a href="{{ route('social_login', ['provider' => 'facebook']) }}" class="btn btn-lg btn-success btn-block">@lang('app.login_with_facebook')</a>
<hr>
<div>
    @lang('app.do_not_have_an_account') <a href="{{ route('register') }}">@lang('app.register')</a>
</div>
<div>
    <a href="{{ route('password.request') }}">@lang('app.forgot_password')</a>
</div>
{!! Form::close() !!}
@endsection
