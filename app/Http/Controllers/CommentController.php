<?php

namespace App\Http\Controllers;


use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Repositories\ChapterRepository;
use App\Repositories\UserRepository;
use App\Repositories\NotificationRepository;
use Auth;

class CommentController extends Controller
{
    protected $comment;
    protected $chapter;
    protected $user;
    protected $notify;

    public function __construct(CommentRepository $comment, ChapterRepository $chapter, UserRepository $user, NotificationRepository $notify)
    {
        $this->comment = $comment;
        $this->chapter = $chapter;
        $this->user = $user;
        $this->notify = $notify;

    }

    public function addComment($id, CommentRequest $request)
    {
        if ($request->ajax()) {
            $chapter = $this->chapter->findOrFail($id);
            $user = $this->user->findOrFail($chapter->story->user_id);
            $comment = $this->comment->create([
                'user_id' => Auth::id(),
                'commentable_type' => 'App\Models\Chapter',
                'commentable_id' => $chapter->id,
                'content' => $request->comment_text,
            ]);
            $this->notify->create([
                'user_id' => $user->id,
                'notifier_id' => Auth::id(),
                'notifiable_id' => $comment->commentable_id,
                'notifiable_type' => $comment->commentable_type,
                'action' => 'post',
                'data' => Auth::user()->full_name . ' đã bình luận sách của bạn',
            ]);

            return view('front.items.comment', compact('comment'))->render();
        }
    }

    public function addReply($id, CommentRequest $request)
    {
        if ($request->ajax()) {
            $comment = $this->comment->findOrFail($id);
            $reply = $this->comment->create([
                'user_id' => Auth::id(),
                'parent_id' => $comment->id,
                'commentable_type' => $comment->commentable_type,
                'commentable_id' => $comment->commentable_id,
                'content' => $request->comment_text,
            ]);

            return view('front.items.reply', compact('reply'))->render();
        }
    }

    public function replies($id, Request $request)
    {
        if ($request->ajax()) {
                $comment = $this->comment->findOrFail($id);
                $replies = $this->comment->getReplies($comment->id, $request->idReply);
                $repliesNext = $this->comment->getRepliesCount($comment->id, $replies->last()->id);
                $key = 'no';
                if ( $replies->count() == config('app.comments_per_page') && $repliesNext > 0){
                    $key = 'yes';
                }
                $content = '';
                foreach ($replies as $reply) {
                    $content = view('front.items.reply', ['reply' => $reply])->render() . $content;
                }

                return response()->json(compact('key', 'content'));
            }
    }

    public function delete($id)
    {
        $comment = $this->comment->findOrFail($id);
        if (Auth::user()->can('delete', $comment)) {
            $success = $comment->delete();
            $message = $success ? trans('app.delete_success') : trans('app.unknow_error');
        } else {
            $success = false;
            $message = trans('app.permission_denied');
        }

        return response()->json(compact('success', 'message'));
    }
}
