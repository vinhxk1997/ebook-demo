<div class="reply d-flex">
    <div class="col-avatar">
        <div class="avatar avatar-sm">
            <img src="{{ get_avatar($reply->user) }}" />
        </div>
    </div>
    <div class="col-main" data-id="{{ $reply->id }}">
        <div class="header">
            <div class="info">
                <a href="{{ route('user_about', ['user' => $reply->user->login_name]) }}">{{ $reply->user->full_name }}</a>
                <small>{{ $reply->created_at->diffForHumans() }}</small>
            </div>
            @can('delete', $reply)
            <div class="dropdown">
                <button class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" data-id="{{ $reply->id }}" class="dropdown-item delete-comment"><i
                            class="fa fa-trash text-danger" aria-hidden="true"></i>
                        @lang('app.delete_this_comment')</a>
                </div>
            </div>
            @endcan
        </div>
        <pre>{{ $reply->content }}</pre>
    </div>
</div>