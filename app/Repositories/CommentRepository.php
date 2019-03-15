<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository
{
    public function getComments($id, $model)
    {
        $comments = $this->with('user')
            ->withCount('replies')
            ->where('parent_id', 0)
            ->where('commentable_type', $model)
            ->where('commentable_id', $id)
            ->orderBy('updated_at', 'desc')
            ->paginate(config('app.comments_per_page'));

        return $comments;
    }

    public function getReplies($id, $idReply)
    {
        $comments = $this->with('user')
            ->where('parent_id', $id);
        if ($idReply != null) {
            $comments = $comments ->where('id', '<', $idReply);
        }
        $comments = $comments->orderBy('created_at', 'desc')
            ->limit(config('app.comments_per_page'))->get();

        return $comments;
    }

    public function getRepliesCount($id, $idReply)
    {
        $comments = $this->where('parent_id', $id);
        if ($idReply != null) {
            $comments = $comments ->where('id', '<', $idReply);
        }
        $comments = $comments->orderBy('created_at', 'desc')
            ->count();

        return $comments;
    }
}
