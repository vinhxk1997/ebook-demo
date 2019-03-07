@extends('front.layouts.user')
@section('title', "People followed by Administrator (@admin)")

@section('tab_content')
<div class="user-following">
    <div class="collection row">
        @foreach ($followings as $following_user)
            <div class="col-6 col-sm-4 col-md-3">
                <div class="card user-card">
                    <div class="background background-sm" style="background-image: url('{{ get_user_cover($following_user) }}')"></div>
                    <a href="{{ route('user_about', ['user' => $following_user->login_name]) }}" class="avatar"><img src="{{ get_avatar($following_user, 1) }}" /></a>
                    <div class="card-body">
                        <h5 class="card-title mb-0 mt-2"><a href="{{ route('user_about', ['user' => $following_user->login_name]) }}">{{ $following_user->full_name }}</a></h5>
                        <small class="d-block">{{ '@' . $following_user->login_name }}</small>
                        @auth
                            @if ($following_user->is_followed)
                                <button class="btn btn-block btn-success mt-2">
                                    <i class="fa fa-user-plus"></i> @lang('app.following')
                                </button>
                            @else
                                <button class="btn btn-block btn-light mt-2">
                                    <i class="fa fa-user-plus"></i> @lang('app.follow')
                                </button>
                            @endif
                        @endauth
                    </div>
                    <footer class="d-flex justify-content-around">
                        <div>
                            <h5>{{ $following_user->stories_count }}</h5>
                            <small>Works</small>
                        </div>
                        <div>
                            <h5>{{ $following_user->save_lists_count }}</h5>
                            <small>Following</small>
                        </div>
                        <div>
                            <h5>{{ $following_user->followers_count }}</h5>
                            <small>Followers</small>
                        </div>
                    </footer>
                </div>
            </div>
        @endforeach
    </div>
    @if ($followings->hasPages())
    <div class="show-more row">
        <div class="col-md-4 offset-md-4">
            <button class="btn btn-block btn-light">@lang('app.show_more') <i class="fa fa-angle-down"></i></button>
        </div>
    </div>
    @endif
</div>
@endsection
