<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NotificationRepository;
use App\Repositories\ChapterRepository;
use App\Repositories\StoryRepository;
use Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    protected $notify;

    public function __construct(NotificationRepository $notify, ChapterRepository $chapter, StoryRepository $story)
    {
        $this->notify = $notify;
        $this->chapter = $chapter;
        $this->story = $story;
    }

    public function read($id, Request $request)
    {
        if ($request->ajax()) {
            $notifications = $this->notify->where('user_id', $id)->get();
            foreach ($notifications as $notification) {
                $notification->update([
                    'read_at' => Carbon::now(),
                ]);
            }
        }
    }

    public function whenComment($id)
    {
        $chapter = $this->chapter->published()->findOrFail($id);
        $chapter_id = $chapter->id;
        $chapter_slug = $chapter->slug;

        return redirect()->route('read_chapter', [$chapter_id, $chapter_slug]);
    }

    public function whenCreateStory($id)
    {
        $story = $this->story->published()->findOrFail($id);
        $story_id = $story->id;
        $story_slug = $story->slug;

        return redirect()->route('story', [$story_id, $story_slug]);
    }
}
