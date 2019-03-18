<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Repositories\StoryRepository;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected $story;

    public function __construct(StoryRepository $story)
    {
        $this->story = $story;
    }

    public function index()
    {
        $archived_stories = Auth::check() ? $this->getArchivedStories() : collect();
        $recommended_stories = $this->story->getRecommendedStories();
        $recent_stories = $this->story->getRecentStories();

        if ($recommended_stories->count() > config('app.random_items')) {
            $recommended_stories = $recommended_stories->random(config('app.random_items'));
        }

        return view('front.home', compact('archived_stories', 'recommended_stories', 'recent_stories'));
    }

    private function getArchivedStories()
    {
        $user = Auth::user();
        if (Cache::has('_reading_stories_' . $user->id)) {
            $archived_stories = Cache::get('_reading_stories_' . $user->id);
        } else {
            $user->load([
                'saveLists.stories' => function ($query) {
                    return $query->published()->withCount(['chapters' => function ($q) {
                        $q->published();
                    }, 'metas']);
                },
                'saveLists.stories.metas',
                'saveLists.stories.user',
            ]);

            $archived_stories = $user->saveLists->map(function ($item) {
                return $item->stories;
            })->flatten(1);

            if ($archived_stories->count() > config('app.random_items')) {
                $archived_stories = $archived_stories->random(config('app.random_items'));
            }
            Cache::put('_reading_stories_' . $user->id, $archived_stories, config('app.cache_time'));
        }
        
        return $archived_stories;
    }

    public function search(Request $request)
    {
        $keyword = urldecode($request->query('q'));
        $stories = Story::search($keyword)->published()
            ->paginate(config('app.per_page'))
            ->appends(['q' => urlencode($keyword)]);
        
        if ($request->ajax()) {
            $content = '';
            foreach ($stories as $story) {
                $content .= view('front.items.meta_story', ['story' => $story])->render();
            }
    
            $stories = $stories->toArray();
            unset($stories['data']);
            $stories['content'] = $content;

            return response()->json($stories);
        }

        return view('front.search', compact('stories', 'keyword'));
    }
}
