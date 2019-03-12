@extends('front.layouts.master')
@section('title', __('app.works'))
@section('content')
<div class="container pt-4">
    <div class="row">
        <div class="col">
            <h2>@lang('app.my_works')</h2>
        </div>
        <div class="col text-right">
            <a class="btn btn-warning btn-sm my-auto" href="{{ route('story_create') }}">@lang('app.new_story')</a>
        </div>
    </div>
    <div class="story-filter">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="hot-tab" data-toggle="tab" href="#published">@lang('app.published')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="new-tab" data-toggle="tab" href="#all">@lang('app.all_stories')</a>
            </li>
        </ul>
    </div>
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="published">
            <div class="stories">
                <div class="row">
                    @foreach ($published_stories as $story)
                    @include('front.items.work_story', compact('story'))
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane fade"  id="all">
            <div class="stories">
                <div class="row">
                    @foreach ($stories as $story)
                    @include('front.items.work_story', compact('story'))
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop
