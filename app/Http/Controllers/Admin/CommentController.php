<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;

class CommentController extends Controller
{
    protected $comment;

    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    public function storyComment()
    {
        $type = 'App\Models\Chapter';
        $comments = $this->comment->with('commentable', 'user', 'replies')->where('commentable_type', $type)
        ->where('parent_id', 0)->get();

        return view('backend.comments.story_comment', compact('comments'));
    }

    public function reviewComment()
    {
        $type = 'App\Models\Review';
        $key = 1;
        $comments = $this->comment->with('commentable', 'user', 'replies')->where('commentable_type', $type)
        ->where('parent_id', 0)->get();

        return view('backend.comments.review_comment', compact('comments', 'key'));
    }

    public function replyComment($id)
    {
        $key = 1;
        $comments = $this->comment->with('commentable', 'user', 'replies')->where('parent_id', $id)->get();

        return view('backend.comments.reply_comment', compact('comments', 'key'));
    }

    public function destroy($id)
    {
        $comment = $this->comment->findOrFail($id);
        $comment->delete();
        
        return redirect()->back()->with('status', __('tran.comment_delete_status'));
    }
}
