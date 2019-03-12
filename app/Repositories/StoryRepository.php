<?php
namespace App\Repositories;

use App\Models\Story;
use Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Container\Container as Application;

class StoryRepository extends BaseRepository
{
    protected $chapter;
    protected $comment;

    public function __construct(Application $app, CommentRepository $comment, ChapterRepository $chapter)
    {
        parent::__construct($app);
        $this->chapter = $chapter;
        $this->comment = $comment;
    }

    public function getRecommendedStories()
    {
        if (Cache::has('recommended_stories')) {
            $recommended_stories = Cache::get('recommended_stories');
        } else {
            $recommended_stories = $this->with([
                'metas',
                'user',
            ])->withCount(['metas', 'chapters'])
            ->where('is_recommended', 1)
            ->limit(config('app.max_random_items'))
            ->get();

            if ($recommended_stories->count() > config('app.random_items')) {
                $recommended_stories = $recommended_stories->random(config('app.random_items'));
            }
            Cache::put('recommended_stories', $recommended_stories, config('app.cache_time'));
        }

        return $recommended_stories;
    }

    public function getRecentStories()
    {
        if (Cache::has('recent_stories')) {
            $recent_stories = Cache::get('recent_stories');
        } else {
            $recent_stories = $this->with([
                'metas',
                'user',
            ])->withCount('chapters')
            ->orderBy('updated_at', 'desc')
            ->limit(config('app.max_random_items'))
            ->get();

            if ($recent_stories->count() > config('app.random_items')) {
                $recent_stories = $recent_stories->random(config('app.random_items'));
            }
            Cache::put('recent_stories', $recent_stories, config('app.cache_time'));
        }

        return $recent_stories;
    }

    public function getStoryRecentComments($story)
    {
        $chapter_ids = $story->chapters->map(function ($chapter) {
            return $chapter->id;
        });

        return $this->comment->with('user')
            ->where('commentable_type', $this->chapter->model())
            ->whereIn('commentable_id', $chapter_ids)
            ->orderBy('updated_at', 'desc')
            ->paginate(config('app.comments_per_page'));
    }

    public function getUserAllStories()
    {
        return $this->where('user_id', Auth::id())
            ->withCount(['publishedChapters', 'chapters'])
            ->paginate(config('app.per_page'));
    }

    public function getUserPublishedStories()
    {
        return $this->where('user_id', Auth::id())
            ->withCount(['publishedChapters', 'chapters'])
            ->where('status', Story::STATUS_PUBLISHED)
            ->paginate(config('app.per_page'));
    }

    
}
