@extends('front.layouts.master')

@section('content')
<div class="profile-layout">
    <header class="background background-lg holderjs" style="background-image: url('?holder.js/1920x600?bg=ccc');">
        <div class="avatar avatar-profile d-block mx-auto">
            <div class="component-wrapper">
                <img src="holder.js/96x96" aria-hidden="true" alt="admin">
            </div>
        </div>
        <h1 class="profile-name h3" aria-label="@lang('app.user_profile', ['name' => 'Administrator'])">
            Administrator
        </h1>
        <p id="alias" aria-label="@lang('app.also_known_as', ['name' => 'admin'])">@admin</p>
        <div class="row header-metadata">
            <div class="col-4 scroll-to-element" data-id="profile-works">
                <p>6</p>
                <p>{{ trans_choice('app.works', 0) }}</p>
            </div>
            <div class="col-4 scroll-to-element" data-id="profile-lists">
                <p>1</p>
                <p>{{ trans_choice('app.reading_lists_choice', 0) }}</p>
            </div>
            <div class="col-4 on-followers" data-toggle="tooltip" data-placement="top" title="6,143 Followers">
                <p class="followers-count">6.1K</p>
                <p>{{ trans_choice('app.followers', 0) }}</p>
            </div>
        </div>
        <div id="page-navigation" class="sub-navigation">
            <div class="container d-flex">
                <nav role="navigation">
                    <ul class="nav nav-tabs">
                        <li data-section="about" class="nav-item">
                            <a class="nav-link on-nav-item{{ Route::is('user_about') ? ' active' : '' }}" href="{{ route('user_about', ['user_name' => 'admin']) }}">@lang('app.about')</a>
                        </li>
                        <li data-section="activity" class="nav-item">
                            <a class="nav-link on-nav-item{{ Route::is('user_conversations') ? ' active' : '' }}" href="{{ route('user_conversations', ['user_name' => 'admin']) }}">@lang('app.conversations')</a>
                        </li>
                        <li data-section="following" class="nav-item">
                            <a class="nav-link on-nav-item{{ Route::is('user_following') ? ' active' : '' }}" href="{{ route('user_following', ['user_name' => 'admin']) }}">@lang('app.following')</a>
                        </li>
                    </ul>
                </nav>
                <div class="actions ml-auto my-auto" role="menu">
                    <button class="btn btn-outline-primary on-follow-user on-unfollow" data-target="_Nhanuyenhuyen_" data-following="true">
                        <span class="fa fa-user-plus mr-1" aria-hidden="true"></span><span
                            class="hidden-xs truncate">@lang('app.follow')</span>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <main id="content" class="container">
        @yield('tab_content')
    </main>
</div>
@endsection
