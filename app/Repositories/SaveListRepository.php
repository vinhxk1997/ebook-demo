<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;

class SaveListRepository extends BaseRepository
{
    public function getSaveLists($user)
    {
        $lists = $this->withCount('stories')
            ->with([
                'stories' => function ($query) {
                    $query->select('id', 'cover_image')->orderBy('id', 'desc');
                },
            ])
            ->where('user_id', $user->id)
            ->orderby('id', 'desc')
            ->paginate(config('app.per_page'));

        $lists->getCollection()->transform(function ($list) use ($user) {
            $list->share_url = urlencode(route('list', ['id' => $list->id]));
            $list->share_text = urlencode(trans(
                'app.a_reading_list_by',
                [
                    'list_name' => $list->name,
                    'user_name' => $user->login_name,
                ]
            ));

            return $list;
        });

        return $lists;
    }
}
