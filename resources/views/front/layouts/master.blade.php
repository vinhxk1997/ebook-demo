<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scale=0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
</head>

<body>
    <nav class="navbar navbar-expand fixed-top navbar-dark bg-dark" id="topNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">eBook</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown" id="metaDropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            @lang('app.discover')
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($categories as $category)
                                <a class="dropdown-item" href="{{ route('meta', ['slug' => $category->slug]) }}"> {{ $category->name }}</a>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('works') }}">@lang('app.create')</a>
                    </li>
                </ul>
                {!! Form::open(['method' => 'get', 'url' => route('search'), 'class' => 'form-inline d-none d-md-inline-block my-2 my-lg-0 mx-3
                flex-grow-1 ', 'id' => 'navbarSearch']) !!}
                {!! Form::text('q', $keyword,
                    [
                        'class' => 'form-control',
                        'placeholder' => __('app.search_stories_and_people'),
                    ]
                ) !!}
                {!! Form::close() !!}
                <ul class="navbar-nav">
                    @auth
                    <li class="nav-item dropdown notify-dropdown d-flex">
                    @if (auth()->user()->notifications()->whereNull('read_at')->count())
                    <a id="notifications" data-id="{{ auth()->user()->id }}" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>
                        <span class="text-danger notify">{{ __('app.notify') }}</span>
                        <span class="badge badge-danger"></span>
                    </a>
                    @else
                    <a id="notifications" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>
                        <span class="notify">{{ __('app.notify') }}</span>
                        <span class="badge badge-danger"></span>
                    </a>
                    @endif
                    <ul class="dropdown-menu" aria-labelledby="notificationsMenu" id="notificationsMenu">
                        
                    @if (auth()->user()->notifications()->count())
                        @foreach (auth()->user()->notifications()->get() as $notification)
                            <li class="dropdown-item notification">
                                <a href="{{ route('read_chapter',['id' => $notification->notifiable_id, 'slug' => 'accusantium-ut-odit-natus-commodi-odio-quibusdam-odit-illum-esse-reiciendis']) }}">{{ $notification->data }}</a>
                            </li>
                        @endforeach
                    @else
                        <li class="dropdown-header">No notifications</li>
                    @endif
                    </ul>
                    </li>
                    <li class="nav-item dropdown user-dropdown d-flex">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                            <img class="user-avatar" src="{{ get_avatar(Auth::user()) }}" alt="{{ Auth::user()->login_name }}" />
                            <span>{{ Auth::user()->full_name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('user_about', ['user' => Auth::user()->login_name]) }}" class="dropdown-item">@lang('app.my_profile')</a>
                            <a href="{{ route('library') }}" class="dropdown-item">@lang('app.library')</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item" id="logout">@lang('app.logout')</a>
                            {!! Form::open(['url' => route('logout'), 'method' => 'post', 'id' => 'logoutForm', 'hidden']) !!}
                            {!! Form::close() !!}
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">@lang('app.login')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">@lang('app.register')</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <main id="app-container">
        @yield('content')
    </main>
    <footer id="app-footer">
        <div class="container">
            <ul id="footer-items" class="d-flex justify-content-center" role="navigation">
                <li><a href="#" rel="nofollow">@lang('app.language')</a></li>
                <li><a href="#" rel="nofollow">@lang('app.about_us')</a></li>
                <li><a href="#" rel="nofollow">@lang('app.terms')</a></li>
                <li><a href="#" rel="nofollow">@lang('app.privacy')</a></li>
                <li><a href="#">@lang('app.help')</a></li>
                <li>© {{ now()->format('Y') }} {{ config('app.name') }}</li>
            </ul>
        </div>
    </footer>
    @section('modal')
    <div class="modal fade" id="storyPreviewModal" tabindex="-1" role="dialog" aria-labelledby="storyPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    @show
    <script>
        var ebook = window.ebook = (ebook || {});
        ebook.base_url = '{{ url('/') }}';
        ebook.lang = {
            delete_list_confirm: '{{ __('app.delete_list_confirm') }}',
            draft: '{{ __('app.draft') }}',
            loading: '{{ __('app.loading') }}',
            unarchive_confirm: '{{ __('app.unarchive_confirm') }}',
            unknow_error: '{{ __('app.unknow_error') }}',
            update_success: '{{ __('app.update_success') }}',
            view_more_reply: '{{ __('app.view_more_reply') }}',
            follow: '{{ __('app.following') }}',
            unfollow: '{{ __('app.follow') }}',
        };
    </script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    @yield('script')
    <script src="{{ asset('js/main.js') }}"></script>
    
</body>

</html>
