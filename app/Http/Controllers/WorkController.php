<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    ChapterFormRequest,
    StoryFormRequest
};
use App\Models\{
    Chapter,
    Meta,
    Story
};
use App\Repositories\{
    ChapterRepository,
    MetaRepository,
    StoryRepository,
    NotificationRepository
};
use Auth;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    private $story;

    public function __construct(ChapterRepository $chapter, MetaRepository $meta, StoryRepository $story, NotificationRepository $notify)
    {
        $this->chapter = $chapter;
        $this->meta = $meta;
        $this->story = $story;
        $this->notify = $notify;
    }

    public function index()
    {
        $stories = $this->story->getUserAllStories();
        $published_stories = $this->story->getUserPublishedStories();

        return view('front.works', compact('stories', 'published_stories'));
    }

    public function createStoryForm()
    {
        if (! Auth::user()->can('create', Story::class)) {
            abort(403);
        }
        $story = createObject([
            'cover_image' => '',
            'title' => '',
            'summary' => '',
            'tags' => '',
            'genre' => 0,
            'is_mature' => 0,
            'is_complete' => 0,
            'chapters' => collect(),
        ]);
        $is_edit = false;

        return view('front.story_form', compact('story', 'is_edit'));
    }

    public function createStory(StoryFormRequest $request)
    {
        if (! Auth::user()->can('create', Story::class)) {
            abort(403);
        }
        $story_data = [
            'user_id' => Auth::id(), 
            'title' =>  $request->input('story_title'),
            'slug' => str_slug($request->input('story_title')),
            'summary' => $request->input('story_summary'),
            'is_mature' => $request->filled('story_rating'),
        ];

        if ($request->hasFile('story_cover')) {
            $stoy_cover = uploadFile(
                $request->file('story_cover'),
                config('app.story_cover_path'),
                config('app.story_cover_sizes')
            );
            $story_data['cover_image'] = $stoy_cover;
        }

        $story = $this->story->create($story_data);

        $tags = processTags($request->input('story_tags'));
        if ($tags) {
            $tags = array_map(function ($tag) {
                return new Meta([
                    'type' => 'tag',
                    'name' => $tag,
                    'slug' => str_slug($tag)
                ]);
            }, $tags);

            $tags = $this->meta->findOrCreateMany($tags, 'slug');
            $tags = $tags->pluck('id')->push($request->input('story_genre'))->unique();
        } else {
            $tags = [$request->input('story_genre')];
        }
        $story->tags()->attach($tags);

        $chapter = $story->chapters()->create([
            'title' => 'Untitled',
            'slug' => 'untitled',
            'content' => '',
        ]);
        
        return [
            'success' => true,
            'action' => 'create',
            'redirectTo' => route('chapter_write', ['story_id' => $story->id, 'chapter_id' => $chapter->id])
        ];
    }

    public function editStoryForm($id)
    {
        $story = $this->story->with(['category', 'tags'])->findOrFail($id);
        if (! Auth::user()->can('update', $story)) {
            abort(403);
        }

        $story->chapters = $story->chapters()->withCount(['votes', 'comments'])->paginate(config('app.per_page'));
        $is_edit = true;
        $story->genre = $story->category->first()->id;
        $story->tags = $story->tags->implode('name', ', ');

        return view('front.story_form', compact('story', 'is_edit'));
    }

    public function editStory($id, Request $request)
    {
        if (! Auth::user()->can('update', $story)) {
            abort(403);
        }

        $story = $this->story->findOrFail($id);

        $story->title = $request->input('story_title');
        $story->slug = str_slug($request->input('story_title'));
        $story->summary = $request->input('story_summary');
        $story->is_mature = $request->filled('story_rating');
        $story->is_complete = $request->filled('story_completed');

        if ($request->hasFile('story_cover')) {
            $stoy_cover = uploadFile(
                $request->file('story_cover'),
                config('app.story_cover_path'),
                config('app.story_cover_sizes')
            );
            if ($story->cover_image) {
                removeFile(
                    $story->cover_image,
                    config('app.story_cover_path'),
                    config('app.story_cover_sizes')
                );
            }
            $story->cover_image = $stoy_cover;
        }

        $story->save();

        $tags = processTags($request->input('story_tags'));
        if ($tags) {
            $tags = array_map(function ($tag) {
                return new Meta([
                    'type' => 'tag',
                    'name' => $tag,
                    'slug' => str_slug($tag)
                ]);
            }, $tags);

            $tags = $this->meta->findOrCreateMany($tags, 'slug');
            $tags = $tags->pluck('id')->push($request->input('story_genre'))->unique();
        } else {
            $tags = [$request->input('story_genre')];
        }
        $story->tags()->attach($tags);
        
        return [
            'success' => true,
            'action' => 'edit',
            'redirectTo' => ''
        ];
    }

    public function deleteStory(Story $story)
    {
        if (! Auth::user()->can('delete', $story)) {
            abort(403);
        }
        if ($story->cover_image) {
            removeFile(
                $story->cover_image,
                config('app.story_cover_path'),
                config('app.story_cover_sizes')
            );
        }
        $story->delete();

        return response()->json([
            'success' => true,
            'redirectTo' => route('works'),
        ]);
    }

    public function updateStory(Story $story)
    {
        if (! Auth::user()->can('update', $story)) {
            abort(403);
        }

        $story->chapters()->update([
            'status' => Chapter::STATUS_DRAFT
        ]);

        $story->status = Story::STATUS_DRAFT;
        $story->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function createChapter(Story $story)
    {
        if (! Auth::user()->can('createChapter', $story)) {
            abort(403);
        }

        $chapter = new Chapter;
        $chapter->story_id = $story->id;
        $chapter->title = trans('app.untitled');
        $chapter->slug = str_slug(trans('app.untitled'));
        $chapter->content = '';
        $chapter->save();

        return response()->json([
            'success' => true,
            'redirectTo' => route('chapter_write', [
                'story_id' => $story->id,
                'chapter_id' => $chapter->id,
            ]),
        ]);
    }

    public function writeChapterForm(Story $story, Chapter $chapter)
    {
        if (! Auth::user()->can('updateChapter', $story)) {
            abort(403);
        }

        $story->chapters = $story->chapters()->select('id', 'story_id', 'title', 'slug')->get();

        return view('front.chapter_form', compact('story', 'chapter'));
    }

    public function writeChapter(Story $story, Chapter $chapter, ChapterFormRequest $request)
    {
        if (!Auth::user()->can('updateChapter', $story)) {
            abort(403);
        }

        $chapter->title = $request->input('chapter_title');
        $chapter->slug = str_slug($request->input('chapter_title'));
        $chapter->content = $request->input('chapter_content');
        $chapter->status = $request->input('publish') ? Chapter::STATUS_PUBLISHED : Chapter::STATUS_DRAFT;
        $chapter->save();

        if ($chapter->status && !$story->is_published) {
            $story->status = Story::STATUS_PUBLISHED;
            if (Auth::check()) {
                $users = auth()->user()->followers()->get();
                foreach ($users as $user) {
                    $this->notify->create([
                        'user_id' => $user->id,
                        'notifier_id' => Auth::id(),
                        'notifiable_id' => $story->id,
                        'notifiable_type' => $this->story->getModelClass(),
                        'action' => 'create',
                        'data' => Auth::user()->full_name . __('tran.story_notify'),
                    ]);
                }
            }
            $story->save();
        }
        
        return response()->json([
            'success' => true
        ]);
    }

    public function deleteChapter(Story $story, Chapter $chapter)
    {
        if (! Auth::user()->can('deleteChapter', $story)) {
            abort(403);
        }
        
        $chapter->delete();
        
        if ($story->chapters()->published()->count() == 0) {
            $story->status = Story::STATUS_DRAFT;
            $story->save();
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function updateChapter(Story $story, Chapter $chapter)
    {
        if (! Auth::user()->can('updateChapter', $story)) {
            abort(403);
        }

        $chapter->status = Chapter::STATUS_DRAFT;
        $chapter->save();
        
        if ($story->chapters()->published()->count() == 0) {
            $story->status = Story::STATUS_DRAFT;
            $story->save();
        }

        return response()->json([
            'success' => true
        ]);
    }

}
