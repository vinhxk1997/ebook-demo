<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\NotificationRepository;
use Auth;

class FollowController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user, NotificationRepository $notify)
    {
        $this->user = $user;
        $this->notify = $notify;
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
                    
                    $this->notify->create([
                        'user_id' => $user_follow->id,
                        'notifier_id' => Auth::id(),
                        'notifiable_id' => auth()->user()->id,
                        'notifiable_type' => $this->user->getModelClass(),
                        'action' => 'follow',
                        'data' => Auth::user()->full_name . __('tran.follow_notify'),
                    ]);
    
                    return response()->json(compact('success'));
                }
            }
        }
    }
}
