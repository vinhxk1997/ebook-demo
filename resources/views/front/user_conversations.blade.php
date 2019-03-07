@extends('front.layouts.user')
@section('title', "Administrator (@admin)'s activity")

@section('tab_content')
<div class="user-activity row">
    <div class="col-sm-8 col-lg-7" id="profile-message-wrapper">
        <section id="profile-messages">
            <div class="activity-feed">
                <div id="broadcast-container" class="d-flex">
                    <div class="avatar avatar-md">
                        <img src="{{ get_avatar(auth()->user()) }}">
                    </div>
                    <div class="ml-2 flex-grow-1">
                        <textarea class="form-control" placeholder="@lang('app.post_a_message')" rows="1"></textarea>
                        <div class="d-flex justify-content-end mt-1">
                            <span class="my-auto"><span>0</span>/2000</span>
                            <button id="broadcast-submit" class="btn btn-sm btn-primary on-post ml-2" disabled>@lang('app.post')</button>
                        </div>
                    </div>
                </div>
                <div class="collection">
                    @for ($i = 0; $i < 2; $i++)
                    <article class="feed-item">
                        <header id="comment-558842802" class="d-flex">
                            <a class="avatar avatar-sm3" href="{{ route('user_about', ['user' => 'admin']) }}">
                                <img src="{{ get_avatar(auth()->user()) }}">
                            </a>
                            <div class="item-details flex-grow-1 ml-2">
                                <h3 class="h6 from-name"><a class="username" href="{{ route('user_about', ['user' => 'admin']) }}">admin</a></h3>
                                <time class="timestamp" datetime="2019-01-09T03:53:27Z">Jan 09</time>
                            </div>
                        </header>
                        <div class="message">
                            <pre>Post text!</pre>
                        </div>
                        <button class="btn btn-light btn-block btn-replies" type="button"><span class="fa fa-comment"></span> {{ trans_choice('app.view_more_replies', 2) }}</button>
                        @for ($j = 0; $j < 2; $j++)
                        <div class="message latest-replies d-flex">
                            <a class="avatar avatar-xs2" href="{{ route('user_about', ['user' => 'admin']) }}">
                                <img src="{{ get_avatar(auth()->user()) }}">
                            </a>
                            <div class="message-wrapper flex-grow-1 ml-2">
                                <h3 class="h6 from-name"><a class="username" href="{{ route('user_about', ['user' => 'admin']) }}">admin</a></h3>
                                <div class="body dark-grey">
                                    <pre><a class="on-user-mention" href="{{ route('user_about', ['user' => 'admin']) }}">@admin</a> reply text</pre>
                                </div>
                                <div class="reply-meta">
                                    <time class="timestamp" datetime="2019-01-09T03:53:42Z">Jan 09</time>
                                    <span class="bullet">&bull;</span>
                                    <span class="reply-wrapper"><a class="on-reply" role="button" href="#">Reply</a></span>
                                </div>
                            </div>
                        </div>
                        @endfor
                        <footer class="reply-form">
                            <div class="d-flex">
                                <div class="avatar avatar-md">
                                    <img src="{{ get_avatar(auth()->user()) }}">
                                </div>
                                <div class="ml-2 flex-grow-1">
                                    <textarea class="form-control" placeholder="@lang('app.write_a_reply')" rows="1"></textarea>
                                    <div class="d-flex justify-content-end mt-1">
                                        <span class="my-auto"><span>0</span>/2000</span>
                                        <button class="btn btn-sm btn-primary ml-2" disabled>@lang('app.post')</button>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </article>
                    @endfor
                </div>
                <button class="btn btn-light btn-block show-more">
                    <span class="show-more-message">
                        <span>@lang('app.loading')</span>
                        <span class="fa fa-spinner fa-spin"></span>
                    </span>
                </button>
            </div>
        </section>
    </div>
    <div class="col-sm-4 col-lg-4" id="profile-feed-wrapper">
        <section id="profile-feed">
            <div class="activity-feed">
                <div class="title-wrapper" id="feed-title">
                    <h4 class="title"><span class="title-text">@lang('app.recent_activity')</span></h4>
                </div>
                <div class="collection">
                    @for ($i = 0; $i < 2; $i++)
                    <article class="feed-item">
                        <header id="comment-558842802" class="d-flex">
                            <a class="avatar avatar-sm3" href="{{ route('user_about', ['user' => 'admin']) }}">
                                <img src="{{ get_avatar(auth()->user()) }}">
                            </a>
                            <div class="item-details flex-grow-1 ml-2">
                                <h3 class="h6 from-name"><a class="username" href="{{ route('user_about', ['user' => 'admin']) }}">admin</a><i class="fa fa-angle-right mx-2"></i><a href="{{ route('user_about', ['user' => 'framgia']) }}" class="username">framgia</a></h3>
                                <time class="timestamp" datetime="2019-01-09T03:53:27Z">Jan 09</time>
                            </div>
                        </header>
                        <div class="message">
                            <pre>Post text!</pre>
                        </div>
                    </article>
                    @endfor
                </div>
                <button class="btn btn-light btn-block show-more" role="button">
                    <span class="show-more-message">
                        <span>@lang('app.show_more')</span>
                        <span class="fa fa-angle-down"></span>
                    </span>
                </button>
            </div>
        </section>
    </div>
</div>
</main>
@endsection
