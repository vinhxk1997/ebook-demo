@extends('front.layouts.simple')
@section('title', __('app.register'))

@section('content')

{!! Form::open(['method' => 'POST', 'url' => route('register'), 'class' => 'form-register']) !!}
<div class="text-center mb-4">
    <h1 class="h3 mb-3 font-weight-normal"><a href="{{ route('home') }}">{{ config('app.name') }}</a></h1>
</div>
@if ($errors->count())
    <div class="alert alert-warning">{!! implode('<br>', $errors->all()) !!}</div>
@endif
<div class="form-label-group">
    {!! Form::text('full_name', null, [
        'id' => 'inputFullName',
        'class' => 'form-control' . ($errors->has('full_name') ? ' is-invalid' : ''),
        'placeholder' => __('app.full_name'),
        'required',
        'autofocus'
    ]) !!}
    
    {!! Form::label('inputFullName', __('app.full_name')) !!}
</div>
<div class="form-label-group">
    {!! Form::email('email', null, [
        'id' => 'inputEmail',
        'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
        'placeholder' => __('app.email_address'),
        'required',
        'autofocus'
    ]) !!}
    
    {!! Form::label('inputEmail', __('app.email_address')) !!}
</div>
<div class="form-label-group">
    {!! Form::text('login_name', null, [
        'id' => 'inputUserName',
        'class' => 'form-control' . ($errors->has('login_name') ? ' is-invalid' : ''),
        'placeholder' => __('app.user_name'),
        'required',
        'autofocus'
    ]) !!}
    
    {!! Form::label('inputUserName', __('app.user_name')) !!}
</div>
<div class="form-label-group">
    {!! Form::password('password', [
        'id' => 'inputPassword',
        'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
        'placeholder' => __('app.password'),
        'required'
    ]) !!}
    
    {!! Form::label('inputPassword', __('app.password')) !!}
</div>
<div class="form-label-group">
    {!! Form::password('password_confirmation', [
        'id' => 'inputPasswordConfirmation',
        'class' => 'form-control',
        'placeholder' => __('app.password_confirmation'),
        'required'
    ]) !!}
    
    {!! Form::label('inputPasswordConfirmation', __('app.password_confirmation')) !!}
</div>

{!! Form::submit(__('app.register'), ['class' => 'btn btn-lg btn-primary btn-block']) !!}
<hr>
<div>
    @lang('app.already_registered') <a href="{{ route('login') }}">@lang('app.login')</a>
</div>
{!! Form::close() !!}
@endsection
