@extends('front.layouts.master')
@section('title', $meta->name)
@section('content')
<div class="stories">
    <div class="container">
        <div class="header py-3">
            <h1>{{ $meta->name }}</h1>
        </div>
        <div class="filter-tabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="hot-tab" data-toggle="tab" href="#hot" role="tab" aria-controls="hot" aria-selected="true">@lang('app.hot')</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new" aria-selected="false" data-url="{{ route('meta_new_stories', ['slug' => $meta->name]) }}">@lang('app.new')</a>
                </li>
            </ul>
        </div>
        <div class="stories">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="hot" role="tabpanel" aria-labelledby="hot-tab">
                    <div class="row" id="metaStories">
                    @foreach ($meta->stories as $story)
                    @include('front.items.meta_story', ['story' => $story])
                    @endforeach
                    </div>
                    @if ($meta->stories->hasPages())
                    <div class="row">
                        <div class="col-sm-6 offset-sm-3">
                            <button class="btn btn-light btn-block on-show-more" data-url="{{ $meta->stories->nextPageUrl() }}" data-target="#metaStories">
                                @lang('app.show_more')
                                <i class="fa fa-angle-down"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="new-tab">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
