@extends('front.layouts.master')
@section('title', __('app.works'))
@section('content')
<div class="container pt-4">
    <div class="row">
        <div class="col">
            <h2>@lang('app.my_works')</h2>
        </div>
        <div class="col text-right">
            <button class="btn btn-warning btn-sm my-auto">@lang('app.new_story')</button>
        </div>
    </div>
    <div class="story-filter">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="hot-tab" data-toggle="tab" href="#published">@lang('app.published')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="new-tab" data-toggle="tab" href="#allStories">@lang('app.all_stories')</a>
            </li>
        </ul>
    </div>
    <div class="stories">
        <div class="list-group">
            @foreach ($stories as $story)
            @include('front.items.work_story', compact('story'))
            @endforeach
        </div>
    </div>
</div>
@stop
