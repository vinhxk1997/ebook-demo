@extends('front.layouts.library')
@section('title', Route::is('library') ? __('app.current_reads') : __('app.archive'))

@section('tab_content')
    <div class="list-controls my-2">
        <div class="text-right">
            <i class="fa fa-lock"></i> @lang('app.private')
        </div>
    </div>
    <div class="collection">
        <div class="row">
            @if ($stories->count())
                @foreach ($stories as $story)
                <div class="col" data-id="{{ $story->id }}">
                    <div class="cover on-mouse-out">
                        <img src="{{ get_story_cover($story, 0) }}" />
                        <div class="overlay p-3">
                            <div class="quick-control text-right">
                                <button class="btn text-white on-unarchive"><i class="fa fa-trash"></i></button>
                            </div>
                            <div class="controls">
                                <a class="control-item btn btn-dark btn-block btn-sm" href="{{ route('read_chapter', ['id' => $story->first_chapter->id, 'slug' => $story->first_chapter->slug]) }}">@lang('app.start_reading')</a>
                                <a class="control-item btn btn-dark btn-block btn-sm" href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}">@lang('app.details')</a>
                                <button class="control-item btn btn-dark btn-block btn-sm on-archive-status">{{ Route::is('library') ? __('app.archive') : __('app.unarchive') }}</button>
                                <div class="control-item dropup button-lists-add" data-id="{{ $story->id }}">
                                    <button class="btn btn-dark btn-block btn-sm on-lists-add">@lang('app.add_to_list')</button>
                                    <div class="dropdown-menu dropup lists"></div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="info d-flex">
                            <div>
                                <strong>{{ $story->title }}</strong>
                                <small>{{ $story->user->login_name }}</small>
                            </div>
                            <a class="avatar avatar-sm flex-shrink-0" href="{{ route('user_about', ['user' => $story->user->login_name]) }}"><img src="{{ get_avatar($story->user) }}" /></a>
                        </div>
                        <div class="meta row">
                            <span class="col-6"><i class="fa fa-eye"></i> {{ $story->views }}</span>
                            <span class="col-6"><i class="fa fa-star"></i> {{ $story->votes }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        @if ($stories->count())
            @if ($stories->hasPages())
            <div class="row mt-3">
                <div class="col-md-6 offset-md-3">
                    <button class="show-more btn btn-light btn-block">
                        @lang('app.show_more')
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            @endif
        @else
        <p class="my-3">
            @lang('app.no_story_available')
        </p>
        @endif
    </div>
@endsection
