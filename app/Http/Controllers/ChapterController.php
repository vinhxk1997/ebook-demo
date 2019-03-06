<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ChapterRepository;
use App\Repositories\CommentRepository;
use App\Repositories\StoryRepository;

class ChapterController extends Controller
{
    protected $chapter;
    protected $comment;
    protected $story;

    public function __construct(ChapterRepository $chapter, CommentRepository $comment, StoryRepository $story)
    {
        $this->chapter = $chapter;
        $this->comment = $comment;
        $this->story = $story;
    }

    public function index($id)
    {
        $chapter = $this->chapter->withCount(['votes', 'comments'])->findOrFail($id);
        $chapter->comments = $this->comment->getComments($chapter->id, $this->chapter->getModel());

        $story = $chapter->story()->with(['user', 'chapters'])->first();
        $story->chapters = $story->chapters->map(function ($chapter) use ($story) {
            $chapter->slug = $story->slug . '-' . $chapter->slug;

            return $chapter;
        });

        $chapter->slug = $story->slug . '-' . $chapter->slug;
        $chapter->share_url = urlencode(route('read_chapter', ['id' => $chapter->id, 'slug' => $chapter->slug]));
        $chapter->share_text = urlencode($chapter->title);

        $next_chapter = $story->chapters->where('id', '>', $chapter->id)->sortBy('id')->first();

        $recommended_stories = $this->story->getRecommendedStories();

        if ($recommended_stories->count() > config('app.chapter_recommended_items')) {
            $recommended_stories = $recommended_stories->random(config('app.chapter_recommended_items'));
        }

        return view('front.chapter', compact('chapter', 'story', 'next_chapter', 'recommended_stories'));
    }

    public function comments($id, Request $request)
    {
        if ($request->ajax()) {
            $chapter = $this->chapter->findOrFail($id);
            $comments = $this->comment->getComments($chapter->id, $this->chapter->getModel());

            $content = '';
            foreach ($comments as $comment) {
                $content .= view('front.items.comment', ['comment' => $comment])->render();
            }
            $comments = $comments->toArray();
            unset($comments['data']);
            $comments['content'] = $content;

            return response()->json($comments);
        }
    }
}
