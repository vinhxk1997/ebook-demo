<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository
{
    public function getComments($id, $model)
    {
        $comments = $this->with('user')
            ->withCount('replies')
            ->where('commentable_type', $model)
            ->where('commentable_id', $id)
            ->orderBy('updated_at', 'desc')
            ->paginate(config('app.comments_per_page'));

        return $comments;
    }
}
