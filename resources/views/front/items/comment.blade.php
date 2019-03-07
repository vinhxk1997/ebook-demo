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
            <div class="dropdown">
                <button class="btn" data-toggle="dropdown"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item"><i class="fa fa-flag text-danger" aria-hidden="true"></i> @lang('app.report_this_comment')</a>
                </div>
            </div>
        </div>
        <pre>{{ $comment->content }}</pre>
        <div class="footer">
            <button class="btn btn-sm btn-link">{{ trans_choice('app.replies', $comment->replies_count) }}</button>
        </div>
    </div>
</div>
