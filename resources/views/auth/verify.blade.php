@extends('front.layouts.simple')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('app.verify_email_address')</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            @lang('app.verify_email_sent')
                        </div>
                    @endif
                    
                    {!! trans('app.verify_email_notify', ['url' => route('verification.resend')]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
