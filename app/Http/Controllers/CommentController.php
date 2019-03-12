<?php

namespace App\Http\Controllers;


use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Repositories\ChapterRepository;
use Auth;

class CommentController extends Controller
{
    protected $comment;
    protected $chapter;

    public function __construct(CommentRepository $comment, ChapterRepository $chapter)
    {
        $this->comment = $comment;
        $this->chapter = $chapter;
    }

    public function addComment($id, CommentRequest $request)
    {
        if ($request->ajax()) {
            $chapter = $this->chapter->findOrFail($id);
            $comment = $this->comment->create([
                'user_id' => Auth::id(),
                'commentable_type' => 'App\Models\Chapter',
                'commentable_id' => $chapter->id,
                'content' => $request->comment_text,
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
            $content = '';
            foreach ($replies as $reply) {
                $content = view('front.items.reply', ['reply' => $reply])->render() . $content;
            }
            $replies = $replies->toArray();
            unset($replies['data']);
            $replies['content'] = $content;

            return response()->json($replies);
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
