<?php

namespace App\Http\Controllers;

use App\Repositories\StoryRepository;
use Illuminate\Http\Request;
use Auth;

class WorkController extends Controller
{
    private $story;

    public function __construct(StoryRepository $story)
    {
        $this->story = $story;
    }

    public function index()
    {
        $stories = $this->story->where('user_id', Auth::id())->paginate(config('app.per_page'));

        return view('front.works', compact('stories'));
    }
}
