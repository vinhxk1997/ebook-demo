<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use DB;

class SaveListRepository extends BaseRepository
{
    public function getSaveLists($user)
    {
        $lists = $this
            ->withCount(['stories' => function ($q) {
                $q->published();
            }])
            ->with([
                'stories' => function ($query) {
                    $query->select('id', 'cover_image')->published()->orderBy('id', 'desc');
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

    public function getAjaxLists($user, $story_id)
    {
        $lists = $this->select(['id', 'name'])
            ->selectRaw(
                '(SELECT COUNT(*) FROM list_story WHERE list_id = save_lists.id AND story_id = ?) as `story_exists`',
                [$story_id]
            )
            ->where('user_id', $user->id)->get();

        return $lists;
    }
}
