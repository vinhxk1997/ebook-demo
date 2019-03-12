<div class="comment">
    <div class="col-avatar">
        <div class="avatar avatar-sm">
            <img src="{{ get_avatar($comment->user) }}" />
        </div>
    </div>
    <div class="col-main">
        <div class="header">
            <div class="info">
                <a href="{{ route('user_about', ['user' => $comment->user->login_name]) }}">{{ $comment->user->full_name }}</a>
                <small>{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            @can('delete', $comment)
            <div class="dropdown">
                <button class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" data-id="{{ $comment->id }}" class="dropdown-item delete-comment"><i class="fa fa-trash text-danger" aria-hidden="true"></i> @lang('app.delete_this_comment')</a>
                </div>
            </div>
            @endcan
        </div>
        <pre>{{ $comment->content }}</pre>
        <div class="footer d-plex">
            <button class="btn btn-sm btn-link on-reply-click">Reply</button>
            <button data-url="{{ route('reply', ['id' => $comment->id]) }}" class="btn btn-sm btn-link on-reply-show">{{ trans_choice('app.replies', $comment->replies_count) }}</button>
            <div class="replies">
            </div>
            @auth
            <div class="add-reply" data-id="{{ $comment->id }}">
            </div>
            @endauth
        </div>
    </div>
</div>
