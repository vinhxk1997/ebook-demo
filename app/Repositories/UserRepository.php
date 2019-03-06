<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function findByLoginName($login_name)
    {
        return $this->where('login_name', $login_name)->first();
    }

    public function findOrFailByLoginName($login_name)
    {
        $user = $this->findByLoginName($login_name);
        if (! $user) {
            abort(404);
        }

        return $user;
    }

    public function getSaveStories($user, $is_archive = 0)
    {
        $stories = $user->archives()
            ->with([
                'user',
                'chapters' => function ($query) {
                    $query->select('id', 'story_id', 'slug')->withCount(['votes']);
                },
            ])
            ->wherePivot('is_archive', $is_archive)
            ->paginate(config('app.per_page'));

        $stories->getCollection()->transform(function ($story) {
            $story->first_chapter = $story->chapters->sortBy('id')->first();
            $story->first_chapter->slug = $story->slug . '-' . $story->first_chapter->slug;

            return $story;
        });

        return $stories;
    }
}
