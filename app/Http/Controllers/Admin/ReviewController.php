<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ReviewRepository;

class ReviewController extends Controller
{
    protected $review;

    public function __construct(ReviewRepository $review)
    {
        $this->review = $review;
    }

    public function index()
    {
        $reviews = $this->review->with('story', 'user')->get();

        return view('backend.review', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = $this->review->findOrFail($id);
        $review->delete();
        
        return redirect()->back()->with('status', __('tran.review_delete_status'));
    }
}
