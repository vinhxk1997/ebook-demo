@extends('front.layouts.user')
@section('title', "People followed by Administrator (@admin)")

@section('tab_content')
<div class="user-following">
    <div class="collection row">
        @for ($i = 0; $i < 8; $i++)
            <div class="col-6 col-sm-4 col-md-3">
                <div class="card user-card">
                    <div class="background background-sm holderjs" style="background-image: url('?holder.js/360x120')"></div>
                    <a href="{{ route('user_about', ['user_name' => 'admin']) }}" class="avatar"><img src="holder.js/128x128?bg=fff" /></a>
                    <div class="card-body">
                        <h5 class="card-title mb-0 mt-2"><a href="{{ route('user_about', ['user_name' => 'admin']) }}">Administrator</a></h5>
                        <small class="d-block">@admin</small>
                        <button class="btn btn-block btn-light mt-2"><i class="fa fa-user-plus"></i> @lang('app.follow')</button>
                    </div>
                    <footer class="d-flex justify-content-around">
                        <div>
                            <h5>16</h5>
                            <small>Works</small>
                        </div>
                        <div>
                            <h5>82</h5>
                            <small>Following</small>
                        </div>
                        <div>
                            <h5>1.2K</h5>
                            <small>Followers</small>
                        </div>
                    </footer>
                </div>
            </div>
        @endfor
    </div>
    <div class="show-more row">
        <div class="col-md-4 offset-md-4">
            <button class="btn btn-block btn-light">@lang('app.show_more') <i class="fa fa-angle-down"></i></button>
        </div>
    </div>
</div>
@endsection
