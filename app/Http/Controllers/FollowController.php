<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Auth;

class FollowController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user; 
    }

    public function unFollow($id, Request $request)
    {
        if ($request->ajax()) {
            $user_follow  = $this->user->findOrFail($id);
            if (Auth::user()->can('unFollow', $user_follow)) {
                $success = Auth::user()->followings()->detach($user_follow->id);

                return response()->json(compact('success'));
            }
        }
    }

    public function follow($id, Request $request)
    {
        if ($request->ajax()) {
            if ($request->ajax()) {
                $user_follow  = $this->user->findOrFail($id);
                if (Auth::user()->can('unFollow', $user_follow)) {
                    $success = Auth::user()->followings()->syncWithoutDetaching($user_follow->id);
    
                    return response()->json(compact('success'));
                }
            }
        }
    }
}
