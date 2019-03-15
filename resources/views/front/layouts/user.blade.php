@extends('front.layouts.master')

@section('content')
<div class="profile-layout">
    <header class="background background-lg" style="background-image: url('{{ get_user_cover($user, 1) }}');">
        <div class="header-container">
            <div class="avatar avatar-profile d-block mx-auto">
                <div class="component-wrapper">
                    <img src="{{ get_avatar($user, 1) }}" aria-hidden="true" alt="{{ $user->login_name }}">
                </div>
            </div>
            <h1 class="profile-name h3" aria-label="@lang('app.user_profile', ['name' => $user->full_name])">
                {{ $user->full_name }}
            </h1>
            <p id="alias" aria-label="@lang('app.also_known_as', ['name' => $user->login_name])">{{ '@' . $user->login_name }}</p>
            <div class="row header-metadata">
                <div class="col-4 scroll-to-element" data-id="profile-works">
                    <p>{{ $user->stories_count }}</p>
                    <p>{{ trans_choice('app.works_choice', $user->stories_count) }}</p>
                </div>
                <div class="col-4 scroll-to-element" data-id="profile-lists">
                    <p>{{ $user->save_lists_count }}</p>
                    <p>{{ trans_choice('app.reading_lists_choice', $user->save_lists_count) }}</p>
                </div>
                <div class="col-4 on-followers" data-toggle="tooltip" data-placement="top" title="{{ trans_choice('app.followers_count', $user->followers_count) }}">
                    <p class="followers-count">{{ $user->followers_count }}</p>
                    <p>{{ trans_choice('app.followers_choice', $user->followers_count) }}</p>
                </div>
            </div>
            <div id="page-navigation" class="sub-navigation">
                <div class="container d-flex">
                    <nav role="navigation">
                        <ul class="nav nav-tabs">
                            <li data-section="about" class="nav-item">
                                <a class="nav-link on-nav-item{{ Route::is('user_about') ? ' active' : '' }}" href="{{ route('user_about', ['user' => $user->login_name]) }}">
                                    @lang('app.about')
                                </a>
                            </li>
                            <li data-section="activity" class="nav-item">
                                <a class="nav-link on-nav-item{{ Route::is('user_conversations') ? ' active' : '' }}" href="{{ route('user_conversations', ['user' => $user->login_name]) }}">
                                    @lang('app.conversations')
                                </a>
                            </li>
                            <li data-section="following" class="nav-item">
                                <a class="nav-link on-nav-item{{ Route::is('user_following') ? ' active' : '' }}" href="{{ route('user_following', ['user' => $user->login_name]) }}">
                                    @lang('app.following')
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="actions ml-auto my-auto" role="menu">
                        @can('follow', $user)
                            @if ($user->is_followed)
                            <button class="btn btn-success on-follow" data-id="{{ $user->id }}" data-target="{{ $user->login_name }}" data-following="true">
                                <span class="fa fa-user-plus mr-1" aria-hidden="true"></span><span
                                    class="hidden-xs truncate">@lang('app.following')</span>
                            </button>
                            @else
                            <button class="btn btn-light on-unfollow" data-id="{{ $user->id }}" data-target="{{ $user->login_name }}" data-following="true">
                                <span class="fa fa-user-plus mr-1" aria-hidden="true"></span><span
                                    class="hidden-xs truncate">@lang('app.follow')</span>
                            </button>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main id="content" class="container">
        @yield('tab_content')
    </main>
</div>
@endsection
