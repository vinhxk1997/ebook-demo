@extends('front.layouts.user')
@section('title', "{$user->full_name} (@{$user->login_name})")

@section('tab_content')
<div class="user-about row">
    <div class="col-md-4">
        <div class="card about-info" id="profile-about">
            <div class="card-body">
                @if (mb_strlen($user->profile->about))
                <pre class="description">{{ $user->profile->about }}</pre>
                @endif
                <p class="date"><span>@lang('app.joined')</span> {{ $user->created_at->format(__('app.d_m_y_format')) }}</p>
                <hr>
                <ul id="profile-links" class="list-unstyled">
                    @if (mb_strlen($user->profile->website))
                    <li class="website"><i class="fa fa-link fa-fw"></i><a href="{{ $user->profile->website }}" target="_blank" rel="nofollow">{{ $user->profile->website }}</a></li>
                    @endif
                    {{--  <li class="facebook"><i class="fa fa-facebook-square fa-fw"></i><a href="#">@lang('app.facebook_profile', ['name' => 'admin'])</a></li>  --}}
                </ul>
                <hr>
                <div id="following-panel">
                    <div class="title">@lang('app.following')</div>
                    <div class="users clearfix">
                        @foreach ($user->followings as $following)
                        <a class="avatar avatar-sm2 pull-left" href="{{ route('user_about', ['user' => $following->login_name]) }}">
                            <img src="{{ get_avatar($following) }}">
                        </a>
                        @endforeach
                        @if ($user->followings_count > config('app.profile_shown_following'))
                        <a href="{{ route('user_following', ['user' => $user->login_name]) }}" class="num-following pull-left">
                            +{{ ($user->followings_count - config('app.profile_shown_following')) }}
                        </a>
                        @endif
                    </div>
                </div>
                <hr>
                <div id="profile-share-links">
                    <div class="title">@lang('app.share_profile')</div>
                    <div class="social-share-links clearfix">
                        <a class="share-facebook social-share" target="_blank" href="https://www.facebook.com/sharer.php?u={{ $user->share_url }}"><span class="fa fa-facebook"></span></a>
                        <a class="share-twitter social-share" target="_blank" href="https://twitter.com/intent/tweet?text={{ $user->share_text }}&url={{ $user->share_url }}"><span class="fa fa-twitter"></span></a>
                        <a class="share-email social-share" target="_blank" href="mailto:?subject={{ $user->share_text }}&body={{ $user->share_text }}%0A{{ $user->share_url }}%0A{{ urlencode($user->profile->about) }}"><span class="fa fa-envelope"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div id="profile-works" class="mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">@lang('app.story_by', ['name' => $user->full_name])</div>
                    <ul class="metadata">
                        <li>{{ trans_choice('app.published_stories', $user->stories_count) }}</li>
                    </ul>
                </div>
                <div class="card-body">
                    <div id="works-item">
                        @foreach ($stories as $story)
                            @include('front.items.story', ['story' => $story, 'in_profile'=> true])
                        @endforeach
                    </div>
                    @if ($user->stories_count > config('app.profile_shown_stories'))
                    <button class="btn btn-light btn-block mt-3">@lang('app.show_more') <i class="fa fa-angle-down"></i></button>
                    @endif
                </div>
            </div>
        </div>
        <div id="profile-lists">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="card-title">{{ trans_choice('app.reading_lists_count', $user->save_lists_count) }}</div>
                </div>
                <div class="card-body">
                    <div class="lists-item">
                        @foreach ($lists as $list)
                        <div class="reading-list">
                            <div class="card-header">
                                <div class="card-title"><a href="{{ route('list', ['id' => $list->id]) }}">{{ $list->name }}</a></div>
                                <ul class="metadata">
                                    <li>@lang('app.reading_list')</li>
                                    <li>{{ trans_choice('app.stories', $list->stories_count) }}</li>
                                </ul>
                            </div>
                            <div class="card-body">
                                @foreach ($list->stories as $list_story)
                                <div class="story-item story" data-url="{{ route('story', ['id' => $list_story->id, 'slug' => $list_story->slug]) }}">
                                    <a class="cover cover-md on-story-preview" href="{{ route('story', ['id' => $list_story->id, 'slug' => $list_story->slug]) }}">
                                        <div class="fixed-ratio fixed-ratio-cover">
                                            <img src="{{ get_story_cover($list_story) }}" alt="{{ $list_story->title }}" />
                                        </div>
                                    </a>
                                    <div class="content">
                                        <div class="info">
                                            <a class="title meta on-story-preview" href="{{ route('story', ['id' => $list_story->id, 'slug' => $list_story->slug]) }}">
                                                {{ $list_story->title }}
                                            </a>
                                        </div>
                                        <div class="meta social-meta">
                                            <span class="read-count" data-toggle="tooltip" data-placement="top" title="{{ $list_story->chapters->sum('views') }}"><span
                                                    class="fa fa-eye"></span> {{ $list_story->chapters->sum('views') }}</span>
                                            <span class="vote-count" data-toggle="tooltip" data-placement="top" title="{{ $list_story->chapters->sum('votes_count') }}"><span
                                                    class="fa fa-star"></span> {{ $list_story->chapters->sum('votes_count') }}</span>
                                            <span class="chapter-count"><span class="fa fa-list-ul"></span> {{ $list_story->chapters_count }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if ($user->save_lists_count > config('app.profile_reading_list_shown'))
                        <button class="btn btn-light btn-block mt-3">@lang('app.show_more') <i class="fa fa-angle-down"></i></button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
