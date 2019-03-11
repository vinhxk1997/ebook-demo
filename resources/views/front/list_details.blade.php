@extends('front.layouts.master')
@section('title', $list->name)
@section('content')
<div class="library">
    <div class="container pt-4">
        @if (auth()->id() == $list->user_id)
        <div class="text-dark d-flex justify-content-between pb-2 mb-4 border-bottom">
            <div><a href="{{ route('lists') }}"><i class="fa fa-angle-left"></i> @lang('app.my_reading_lists')</a></div>
            <div>@lang('app.public') <i class="fa fa-unlock"></i></div>
        </div>
        @endif
        <div class="list-details row" data-url="{{ route('list', ['id' => $list->id]) }}">
            <div class="col-sm-3">
                <div class="list-cover text-center cover mb-2">
                    <img src="{{ get_story_cover($stories->first(), 1) }}" />
                </div>
                <div class="hide-on-edit">
                    <h1 class="h2" id="listName">{{ $list->name }}</h1>
                    <p>{{ trans_choice('app.stories', $list->stories_count) }}</p>
                    @can('edit', $list)
                    <p>
                        <button class="btn btn-primary on-edit-list">
                            @lang('app.edit')
                        </button>
                    </p>
                    @endcan
                    <div class="list-share">
                        <a class="social-share" target="_blank" href="https://www.facebook.com/sharer.php?u={{ $list->share_url }}">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x text-facebook"></i>
                                <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <a class="social-share" target="_blank" href="https://twitter.com/intent/tweet?text={{ $list->share_text }}&url={{ $list->share_url }}">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x text-twitter"></i>
                                <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <a class="social-share" target="_blank" href="mailto:?subject={{ $list->share_text }}&body={{ $list->share_text }}%0A{{ $list->share_url }}">
                            <span class="fa-stack fa-lg">
                                <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                <i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                    </div>
                </div>
                @can('edit', $list)
                <div class="show-on-edit flex-column">
                    <div class="mb-2">
                        {!! Form::text('list_name', $list->name, ['class' => 'form-control', 'id' => 'listNameInput']) !!}
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary on-edit-list-submit">@lang('app.done')</button>
                        <button type="button" class="btn btn-warning on-delete-list" data-delete-url="{{ route('delete_list', ['id' => $list->id, 'source' => 'details']) }}">
                            @lang('app.delete_list')
                        </button>
                    </div>
                </div>
                @endcan
            </div>
            <div class="col-sm-9">
                <div class="card">
                    <div class="card-header show-on-edit justify-content-end">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="selectAll" autocomplete="off">
                            <label class="custom-control-label" for="selectAll">@lang('app.select_all')</label>
                        </div>
                    </div>
                    <div id="listStories" class="list-group list-group-flush on-edit">
                    @foreach ($stories as $story)
                        @include('front.items.list_story', compact('story'))
                    @endforeach
                    </div>
                </div>
                @if ($list->stories_count > config('app.per_page'))
                <div class="row mt-3">
                    <div class="col-sm-6 offset-sm-3">
                        <button class="btn btn-light btn-block on-show-more" data-url="{{ route('list', ['list' => $list->id, 'page' => 2]) }}" data-target="#listStories">
                            @lang('app.show_more')
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div id="listControls" class="navbar navbar-light bg-light border-top fixed-bottom hide">
    <span class="navbar-text font-weight-bold">
        <span id="selectedCount">0</span> @lang('app.selected')
    </span>
    <div class="ml-auto">
        <button class="btn btn-outline-dark" id="removeFromList" data-url="{{ route('remove_list_stories', ['id' => $list->id]) }}">
            <i class="fa fa-trash fa-2x"></i>
    </div>
</div>
@stop
