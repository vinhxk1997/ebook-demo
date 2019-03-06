@extends('front.layouts.simple')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('app.reset_password')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {!! Form::open(['url' => route('password.email'), 'method' => 'POST']) !!}
                        <div class="form-group row">
                            {!! Form::label('email', trans('app.email_address'), [
                                'class' => 'col-md-4 col-form-label text-md-right',
                            ]) !!}
                            <div class="col-md-6">
                                {!! Form::email('email', old('email'), [
                                    'id' => 'email',
                                    'class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''),
                                    'required'
                                ]) !!}
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {!! Form::submit(trans('app.send_password_reset_link'), [
                                    'class' => 'btn btn-primary'
                                ]) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
