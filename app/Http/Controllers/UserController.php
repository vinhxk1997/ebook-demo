<?php

namespace App\Http\Controllers;

use App\Repositories\SaveListRepository;
use App\Repositories\StoryRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Auth, DB, View;

class UserController extends Controller
{
    private $user;
    private $story;
    private $saveList;

    private $currentProfile;

    public function __construct(UserRepository $user, StoryRepository $story, SaveListRepository $saveList)
    {
        $this->middleware(function ($request, $next) {
            $currentProfile = $this->user->with([
                    'profile',
                    'followings' => function ($q) {
                        $q->where('follows.followed_user_id', Auth::id())->limit(1);
                    }
                ])
                ->withCount([
                    'stories',
                    'saveLists',
                    'followers',
                    'followings',
                ])
                ->findOrFailByLoginName($request->route('user'));
            
                $currentProfile->share_url = urlencode(route('user_about', ['user' => $currentProfile->login_name]));
                $currentProfile->share_text = urlencode(__('app.checkout_user_profile', [
                    'user_name' => $currentProfile->full_name,
                    'app_name' => config('app.name'),
                ]));

                if (Auth::check() && Auth::user()->can('follow', $currentProfile)) {
                    $currentProfile->is_followed = DB::table('follows')
                        ->where('followed_user_id', Auth::id())
                        ->where('following_user_id', $currentProfile->id)
                        ->count();
                }

            View::share('user', $currentProfile);
            $this->currentProfile = $currentProfile;
        
            return $next($request);
        });
        
        $this->user = $user;
        $this->story = $story;
        $this->saveList = $saveList;
    }

    public function index()
    {
        $this->currentProfile->load([
            'followings' => function ($q) {
                $q->limit(config('app.shown_following'));
            }
        ]);

        $stories = $this->story->with(
            [
                'metas',
                'chapters' => function ($q) {
                    $q->select('id', 'story_id', 'views')->withCount('votes');
                }
            ]
        )
            ->withCount(['metas', 'chapters'])
            ->where('user_id', $this->currentProfile->id)
            ->limit(config('app.profile_shown_stories'))
            ->get();
        
        $lists = $this->saveList->withCount('stories')
            ->with([
                'stories' => function ($q) {
                    $q->with([
                        'chapters' => function ($q) {
                            $q->select('id', 'story_id', 'views')->withCount('votes');
                        }
                    ])->withCount('chapters')->limit(config('app.max_random_items'));
                }
            ])
            ->where('user_id', $this->currentProfile->id)
            ->limit(config('app.profile_reading_list_shown'))
            ->get();

        $lists = $lists->map(function ($list) {
            if ($list->stories->count() > config('app.profile_list_shown_stories')) {
                $list->stories = $list->stories->random(config('app.profile_list_shown_stories'));
            }

            return $list;
        });

        return view('front.user_about', compact('stories', 'lists'));
    }

    public function conversations()
    {
        return view('front.user_conversations');
    }

    public function following()
    {
        $followings = $this->user
            ->selectRaw('users.*, follows.followed_user_id as pivot_followed_user_id, follows.following_user_id as pivot_following_user_id');
        if (Auth::check()) {
            $followings = $followings->selectRaw('(SELECT COUNT(*) FROM follows as sub_follows WHERE following_user_id = follows.following_user_id AND followed_user_id = ?) as is_followed', [Auth::id()]);
        }
        $followings = $followings->join('follows', 'users.id', '=', 'follows.following_user_id')
            ->withCount(['stories', 'saveLists', 'followers'])
            ->where('follows.followed_user_id', $this->currentProfile->id)
            ->paginate(config('app.followings_per_page'));
        
        

        return view('front.user_following', compact('followings'));
    }
}
