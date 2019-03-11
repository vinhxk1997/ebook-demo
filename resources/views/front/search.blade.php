@extends('front.layouts.master')
@section('title', __('app.search'))
@section('content')
<div class="stories">
    <div class="container">
        <div class="header py-3">
            <h1>{{ __('app.search') }}{{ $keyword ? ': ' . $keyword : '' }}</h1>
        </div>
        <div class="stories">
            <div class="row" id="searchResult">
            @foreach ($stories as $story)
            @include('front.items.meta_story', ['story' => $story])
            @endforeach
            </div>
            @if ($stories->hasPages())
            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    <button class="btn btn-light btn-block on-show-more" data-url="{{ $stories->nextPageUrl() }}" data-target="#searchResult">
                        @lang('app.show_more')
                        <i class="fa fa-angle-down"></i>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
