@extends('front.layouts.master')

@section('content')
<div class="library">
    <div class="container">
        <div class="header py-3">
            <h1>@lang('app.library')</h1>
        </div>
        <div class="library-tab">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link{{ Route::is('library') ? ' active' : '' }}" href="{{ route('library') }}">@lang('app.current_reads')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ Route::is('archive') ? ' active' : '' }}" href="{{ route('archive') }}">@lang('app.archive')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ Route::is('lists') ? ' active' : '' }}" href="{{ route('lists') }}">@lang('app.reading_lists')</a>
                </li>
            </ul>
        </div>
        <div class="stories">
            @yield('tab_content')
        </div>
    </div>
</div>
@endsection
