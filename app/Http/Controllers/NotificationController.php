<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NotificationRepository;
use Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    protected $notify;

    public function __construct(NotificationRepository $notify)
    {
        $this->notify = $notify;
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
}
