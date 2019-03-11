@extends('front.layouts.master')
@section('title', $story->title)
@section('content')
<div id="story-landing">
    <header class="background story-background" style="background-image: url('{{ get_story_cover($story, 2) }}');">
        <div class="header-container">
            <div class="container">
                <div class="cover">
                    <img src="{{ get_story_cover($story, 1) }}" height="281" width="180" />
                </div>
                <h1>{{ $story->title }}</h1>
                <div class="story-stats">
                    <span title="@lang('app.view_count', ['count' => $story->views])">@lang('app.view_count', ['count' => $story->views])</span>
                    <span title="@lang('app.vote_count', ['count' => $story->votes])">@lang('app.vote_count', ['count' => $story->votes])</span>
                    <span>@lang('app.chapter_count', ['count' => $story->chapters_count])</span>
                </div>
                <div class="story-author">
                    <a href="#" class="avatar avatar-md pull-left">
                        <img src="{{ get_avatar($story->user) }}" width="48" height="48" alt="{{ $story->user->full_name }}" />
                    </a>
                    <strong>@lang('app.by') <a href="{{ route('user_about', ['user' => $story->user->login_name]) }}">{{ $story->user->login_name }}</a></strong>
                    <small title="@lang('app.first_published'): {{ $story->created_at->format(__('app.d_m_y_format')) }}">
                        @if ($story->is_completed)
                        <span>@lang('app.completed')</span>
                        @else
                        <span>@lang('app.ongoing') - @lang('app.updated') {{ $story->updated_at->format(__('app.d_m_y_format')) }}</span>
                        @endif
                    </small>
                </div>
                <div id="story-share" class="story-share">
                    <a class="share-facebook social-share" rel="nofollow" target="_blank" href="https://www.facebook.com/sharer.php?u={{ $story->share_url }}">
                        <span class="fa fa-facebook" aria-hidden="true"></span>
                    </a>
                    <a class="share-twitter social-share" rel="nofollow" target="_blank" href="https://twitter.com/intent/tweet?text={{ $story->share_text }}&url={{ $story->share_url }}">
                        <span class="fa fa-twitter" aria-hidden="true"></span>
                    </a>
                    <a class="share-post-to-profile" href="#">
                        <span class="fa fa-user" aria-hidden="true"></span>
                    </a>
                    <div class="button-group position-relative d-inline-block">
                        <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="fa fa-ellipsis-h"
                                aria-hidden="true"></span></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item share-embed" href="#" data-share-channel="embed">
                                <span class="fa fa-fw fa-code" aria-hidden="true"></span>
                                @lang('app.embed_story')
                            </a>
                            <a class="dropdown-item share-email" target="_blank" href="mailto:?subject={{ $story->share_text }}&body={{ $story->share_text }}%0A{{ $story->share_url }}">
                                <span class="fa fa-fw fa-inbox" aria-hidden="true"></span>
                                @lang('app.share_via_email')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <main class="card card-no-top">
                    <div class="card-body">
                        <div class="story-actions">
                            <a href="{{ route('read_chapter', ['id' => $first_chapter->id, 'slug' => $first_chapter->slug]) }}" class="btn btn-primary btn-sm start-reading">
                                @lang('app.read')
                            </a>
                            @auth
                            <div class="d-inline-block dropdown button-lists-add" data-id="{{ $story->id }}">
                                <button class="btn btn-sm btn-primary on-lists-add">+</button>
                                <div class="dropdown-menu lists"></div>
                            </div>
                            @endauth
                        </div>
                        <h2 class="story-summary">
                            {{ $story->summary }}
                        </h2>
                        <div class="story-tags">
                            @foreach ($story->metas as $meta)
                            <a href="{{ route('meta', ['slug' => $meta->slug]) }}" class="tag-item">{{ $meta->name }}</a>
                            @endforeach
                        </div>
                        <div class="story-tabs">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="comments-tab" data-toggle="tab" href="#comments"
                                        role="tab" aria-controls="comments" aria-selected="true">@lang('app.recent_comments')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="chapters-tab" data-toggle="tab" href="#chapters" role="tab"
                                        aria-controls="chapters" aria-selected="false">@lang('app.table_of_contents')</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                                    <ul class="list-group list-group-flush list-comments">
                                        @foreach ($recent_comments as $comment)
                                        <li class="list-group-item">
                                            <div class="header clearfix">
                                                <div class="avatar avatar-sm">
                                                    <img src="{{ get_avatar($comment->user) }}" />
                                                </div>
                                                <div class="info">
                                                    <a class="username" href="{{ route('user_about', ['user' => $comment->user->login_name]) }}">{{ $comment->user->full_name }}</a> on <a class="chapername"
                                                        href="{{ route('read_chapter', ['id' => $comment->chapter->id,  'slug' => $comment->chapter->slug]) }}">{{ $comment->chapter->title }}</a>
                                                    <small>{{ $comment->created_at->format(__('app.d_m_y_format')) }}</small>
                                                </div>
                                            </div>
                                            <div class="content">{{ $comment->content }}</div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="chapters" role="tabpanel" aria-labelledby="chapters-tab">
                                    <div class="list-group list-group-flush list-chapters">
                                        @foreach ($story->chapters as $chapter)
                                        <a href="{{ route('read_chapter', ['id' => $chapter->id, 'slug' => $chapter->slug]) }}" class="list-group-item">{{ $chapter->title }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div class="col-md-4">
                <div class="card card-no-top">
                    <div class="card-body pt-3">
                        <a href="#">@lang('app.report_this_story')</a>
                    </div>
                </div>
                <div class="similar-stories card card-simple-header">
                    <h4 class="card-header">@lang('app.you_will_also_like')</h4>
                    <div class="card-body stories">
                        @foreach ($recommended_stories as $recommended_story)
                        <div class="story" data-url="{{ route('story', ['id' => $recommended_story->id, 'slug' => $recommended_story->slug]) }}">
                            <a href="{{ route('story', ['id' => $recommended_story->id, 'slug' => $recommended_story->slug]) }}" class="d-flex on-story-preview">
                                <div class="cover cover-sm flex-shrink-0">
                                    <img src="{{ get_story_cover($recommended_story, 0) }}" />
                                </div>
                                <div class="d-flex flex-column">
                                    <h4 class="story-title">{{ $recommended_story->title }}</h4>
                                    <small class="story-author">@lang('app.by') {{ $recommended_story->user->login_name }}</small>
                                    <div class="story-stats small mt-auto">
                                        <span class="view-count"><i class="fa fa-eye"></i> {{ $recommended_story->views }}</span>
                                        <span class="vote-count"><i class="fa fa-star"></i> {{ $recommended_story->views }}</span>
                                        <span class="chapter-count"><i class="fa fa-list-ul"></i> {{ $recommended_story->chapters_count }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
