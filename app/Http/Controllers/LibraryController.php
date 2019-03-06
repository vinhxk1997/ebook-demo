<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReadingListRequest;
use App\Models\SaveList;
use App\Repositories\SaveListRepository;
use App\Repositories\UserRepository;
use Auth;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    private $saveList;
    private $user;

    public function __construct(SaveListRepository $saveList, UserRepository $user)
    {
        $this->saveList = $saveList;
        $this->user = $user;
    }

    public function library()
    {
        $stories = $this->user->getSaveStories(Auth::user(), 0);

        return view('front.library_save', compact('stories'));
    }

    public function archive()
    {
        $stories = $this->user->getSaveStories(Auth::user(), 1);

        return view('front.library_save', compact('stories'));
    }

    public function lists(Request $request)
    {
        $lists = $this->saveList->getSaveLists(Auth::user());

        if ($request->ajax()) {
            return $this->listsAjax($lists);
        }

        return view('front.library_list', compact('lists'));
    }

    private function listsAjax($lists)
    {
        $content = '';
        foreach ($lists as $list) {
            $content .= view('front.items.reading_list', ['list' => $list])->render();
        }
        $lists = $lists->toArray();
        unset($lists['data']);
        $lists['content'] = $content;

        return response()->json($lists);
    }

    public function createList(CreateReadingListRequest $request)
    {
        $source = 'library';
        $data = null;

        if (Auth::user()->can('create', SaveList::class)) {
            $list_data = [
                'user_id' => Auth::id(),
                'name' => $request->list_name,
            ];
            $list = $this->saveList->create($list_data);
            $list->stories = collect();
            $list->stories_count = 0;
            $list->share_url = urlencode(route('list', ['id' => $list->id]));
            $list->share_text = urlencode(trans(
                'app.a_reading_list_by',
                [
                    'list_name' => $list->name,
                    'user_name' => Auth::user()->login_name,
                ]
            ));

            if ($request->query('source') === 'library') {
                $data = view('front.items.reading_list', ['list' => $list])->render();
            } else {
                $data = $list;
            }

            $success = true;
        } else {
            $success = false;
        }

        $message = $success ? trans('app.list_create_success') : trans('app.permission_denied');

        return response()->json(compact('source', 'success', 'message', 'data'));
    }

    public function delete(SaveList $list)
    {
        if (Auth::user()->can('delete', $list)) {
            $success = $list->delete();
            $message = $success ? trans('app.delete_success') : trans('app.unknow_error');
        } else {
            $success = false;
            $message = trans('app.permission_denied');
        }

        return response()->json(compact('success', 'message'));
    }
}
