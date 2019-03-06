<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Story;
use App\Models\Comment;
use App\Models\Meta;
use App\Models\Report;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::count();
        $story = Story::count();
        $comment = Comment::count();
        $meta = Meta::count();
        $report = Report::count();
        $review = Review::count();

        return view('backend.index', compact('user', 'story', 'comment', 'meta', 'report', 'review'));
    }
}
