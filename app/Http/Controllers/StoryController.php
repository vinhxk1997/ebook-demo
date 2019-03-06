<?php

namespace App\Http\Controllers;

use App\Repositories\StoryRepository;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    protected $story;

    public function __construct(StoryRepository $story)
    {
        $this->story = $story;
    }

    public function story($id, Request $request)
    {
        if ($request->ajax()) {
            return $this->ajaxStoryInfo($id);
        } else {
            return $this->getStoryInfo($id);
        }
    }

    private function ajaxStoryInfo($id)
    {
        $story = $this->story->with([
            'metas',
            'chapters' => function ($query) {
                return $query->select('id', 'story_id')->withCount('votes');
            },
            'user',
        ])->withCount(['metas', 'chapters'])->findOrFail($id);

        return view('front.story_preview', compact('story'));
    }

    private function getStoryInfo($id)
    {
        $story = $this->story->with([
            'metas',
            'chapters' => function ($query) {
                return $query->withCount('votes')->orderBy('id', 'asc');
            },
            'user',
        ])->withCount(['metas', 'chapters'])->findOrFail($id);

        $story->chapters = $story->chapters->map(function ($chapter) use ($story) {
            $chapter->slug = $story->slug . '-' . $chapter->slug;

            return $chapter;
        });

        $story->votes_count = $story->chapters->sum('votes_count');
        $story->share_text = urlencode($story->title);
        $story->share_url = urlencode(route('story', ['id' => $story->id, 'slug' => $story->slug]));
        $first_chapter = $story->chapters->first();
        $recent_comments = $this->story->getStoryRecentComments($story);

        $recent_comments = $recent_comments->map(function ($comment) use ($story) {
            $comment->chapter = $story->chapters->find($comment->commentable_id);

            return $comment;
        });

        $recommended_stories = $this->story->getRecommendedStories();

        return view('front.story', compact('story', 'first_chapter', 'recent_comments', 'recommended_stories'));
    }
}
