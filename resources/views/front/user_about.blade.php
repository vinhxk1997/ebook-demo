@extends('front.layouts.user')
@section('title', "Administrator (@admin)")

@section('tab_content')
<div class="user-about row">
    <div class="col-md-4">
        <div class="card about-info" id="profile-about">
            <div class="card-body">
                <pre class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo et totam sequi voluptate eligendi nihil fugit, ullam aperiam tempora, obcaecati reprehenderit ad recusandae natus, expedita sit cumque doloremque ipsum dolore?</pre>
                <p class="date"><span>@lang('app.joined')</span> March 20, 2011</p>
                <hr>
                <ul id="profile-links" class="list-unstyled">
                    <li class="website"><i class="fa fa-link fa-fw"></i><a href="#">http://google.com</a></li>
                    <li class="facebook"><i class="fa fa-facebook-square fa-fw"></i><a href="#">@lang('app.facebook_profile', ['name' => 'admin'])</a></li>
                </ul>
                <hr>
                <div id="following-panel">
                    <div class="title">@lang('app.following')</div>
                    <div class="users clearfix">
                        @for ($i = 0; $i < 5; $i++)
                        <a class="avatar avatar-sm2 pull-left" href="#">
                            <img src="holder.js/36x36">
                        </a>
                        @endfor
                        <a href="{{ route('user_following', ['user_name' => 'admin']) }}" class="num-following pull-left">+1</a>
                    </div>
                </div>
                <hr>
                <div id="profile-share-links">
                    <div class="title">@lang('app.share_profile')</div>
                    <div class="social-share-links clearfix">
                        <a class="share-facebook social-share" target="_blank" href="#"><span class="fa fa-facebook"></span></a>
                        <a class="share-twitter social-share" target="_blank" href="#"><span class="fa fa-twitter"></span></a>
                        <a class="share-email social-share" target="_blank" href="#"><span class="fa fa-envelope"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div id="profile-works" class="mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">@lang('app.story_by', ['name' => 'Administrator'])</div>
                    <ul class="metadata">
                        <li>{{ trans_choice('app.published_stories', 5) }}</li>
                    </ul>
                </div>
                <div class="card-body">
                    <div id="works-item">
                        @for ($i = 0; $i < 2; $i++)
                            @include('front.items.story', ['in_profile'=> true])
                        @endfor
                    </div>
                    <button class="btn btn-light btn-block mt-3">@lang('app.show_more') <i class="fa fa-angle-down"></i></button>
                </div>
            </div>
        </div>
        <div id="profile-lists">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="card-title">{{ trans_choice('app.reading_lists_count', 2) }}</div>
                </div>
                <div class="card-body">
                    <div class="lists-item">
                        @for ($i = 0; $i < 2; $i++)
                        <div class="reading-list">
                            <div class="card-header">
                                <div class="card-title"><a href="#">List name</a></div>
                                <ul class="metadata">
                                    <li>@lang('app.reading_list')</li>
                                    <li>{{ trans_choice('app.stories', 2) }}</li>
                                </ul>
                            </div>
                            <div class="card-body">
                                @for ($j = 0; $j < 3; $j++)
                                <div class="story-item">
                                    <a class="cover cover-md" href="{{ route('story', ['slug' => 'story-title']) }}">
                                        <div class="fixed-ratio fixed-ratio-cover">
                                            <img src="holder.js/144x225" alt="Story title" />
                                        </div>
                                    </a>
                                    <div class="content">
                                        <div class="info">
                                            <a class="title meta on-story-preview" href="{{ route('story', ['slug' => 'story-title']) }}">Story
                                                title</a>
                                        </div>
                                        <div class="meta social-meta">
                                            <span class="read-count" data-toggle="tooltip" data-placement="top" title="1,473,463 Read"><span
                                                    class="fa fa-eye"></span> 1.4M</span>
                                            <span class="vote-count" data-toggle="tooltip" data-placement="top" title="71,812 Votes"><span
                                                    class="fa fa-star"></span> 71.8K</span>
                                            <span class="chapter-count"><span class="fa fa-list-ul"></span> 92</span>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                        @endfor
                    </div>
                    <button class="btn btn-light btn-block mt-3">@lang('app.show_more') <i class="fa fa-angle-down"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
