<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Repositories\ChapterRepository;

class ChapterController extends Controller
{
    protected $chapterRepo;
    
    public function __construct(ChapterRepository $chapter)
    {
        $this->chapterRepo = $chapter;
    }

    public function show($id)
    {
        $chapters = $this->chapterRepo->with('story')->where('story_id', $id)->get();

        return view('backend.stories.detail', compact('chapters'));
    }

    public function chapterDetail($id)
    {
        $chapter = $this->chapterRepo->findorFail($id);

        return view('backend.stories.chapter', compact('chapter'));
    }

    public function destroy($id)
    {
        $chapter = $this->chapterRepo->findOrFail($id);
        $chapter->delete();
        
        return redirect()->back()->with('status', __('tran.chapter_delete_status'));
    }
}
