@extends('front.layouts.simple')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('app.reset_password')</div>

                <div class="card-body">
                    {!! Form::open(['url' => route('password.update'), 'method' => 'get']) !!}
                        {!! Form::hidden('token', $token) !!}
                        <div class="form-group row">
                            {!! Form::label('email', trans('app.email_address'), [
                                'class' => 'col-md-4 col-form-label text-md-right',
                            ]) !!}
                            <div class="col-md-6">
                                
                                {!! Form::email('email', ($email ?? old('email')), [
                                    'id' => 'email',
                                    'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                                    'required',
                                    'autofocus',
                                ]) !!}
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('password', trans('app.password'), [
                                'class' => 'col-md-4 col-form-label text-md-right',
                            ]) !!}
                            <div class="col-md-6">
                                {!! Form::password('password', [
                                    'id' => 'password',
                                    'class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''),
                                    'required',
                                ]) !!}
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            {!! Form::label('password-confirm', trans('app.password_confirmation'), [
                                'class' => 'col-md-4 col-form-label text-md-right',
                            ]) !!}
                            <div class="col-md-6">
                                {!! Form::password('password_confirmation', [
                                    'id' => 'password-confirm',
                                    'class' => 'form-control',
                                    'required',
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {!! Form::submit(trans('app.reset_password'), [
                                    'class' => 'btn btn-primary'
                                ]) !!}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
