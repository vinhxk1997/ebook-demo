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
            ->where('parent_id', $id)
            ->where('id', '<', $idReply)
            ->orderBy('created_at', 'desc')
            ->paginate(config('app.comments_per_page'));

        return $comments;
    }
}
