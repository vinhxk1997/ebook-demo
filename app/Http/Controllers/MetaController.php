<?php

namespace App\Http\Controllers;

use App\Repositories\MetaRepository;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    protected $meta;

    public function __construct(MetaRepository $meta)
    {
        $this->meta = $meta;
    }

    public function stories($meta_slug, Request $request)
    {
        $meta = $this->meta->findOrFailBySlug($meta_slug);
        $meta->stories = $meta->stories()->published()->with([
            'metas',
            'user',
        ])
        ->withCount(['chapters' => function ($q) {
            $q->published();
        }])->orderBy('views', 'desc')->paginate(config('app.per_page'));

        if ($request->ajax()) {
            return $this->ajaxStories($meta->stories);
        }

        return view('front.stories', compact('meta'));
    }

    private function ajaxStories($stories)
    {
        $content = '';
        foreach ($stories as $story) {
            $content .= view('front.items.meta_story', ['story' => $story])->render();
        }

        $stories = $stories->toArray();
        unset($stories['data']);
        $stories['content'] = $content;

        return response()->json($stories);
    }

    public function newStories($meta_slug, Request $request)
    {
        if ($request->ajax()) {
            $meta = $this->meta->with([
                'stories' => function ($query) {
                    return $query->published()->orderBy('updated_at', 'desc')->paginate(config('app.per_page'));
                },
            ])->findOrFailBySlug($meta_slug);
            $new_stories = $meta->stories;

            return view('front.new_stories', compact('new_stories'));
        }
    }
}
