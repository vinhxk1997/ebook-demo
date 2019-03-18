<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    CreateReadingListRequest,
    EditReadingListRequest
};
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

    // view reading stories
    public function library()
    {
        $stories = $this->user->getSaveStories(Auth::user(), 0);

        return view('front.library_save', compact('stories'));
    }

    // view archive stories
    public function archive()
    {
        $stories = $this->user->getSaveStories(Auth::user(), 1);

        return view('front.library_save', compact('stories'));
    }

    // archive a story
    public function archiveStory(Request $request)
    {
        $story_id = $request->story_id;

        $action  = null;
        $success = false;
        $message = null;

        if (! $story_id) {
            $message = trans('app.bad_data');
        } else {
            $archive = Auth::user()->archives()->published()->where('story_id', $story_id)->first();

            if (! $archive) {
                try {
                    Auth::user()->archives()->attach($story_id);
                    $success = true;
                } catch (\Exception $e) {
                    return $message = trans('app.bad_data');
                }
            } else {
                $success = true;
                Auth::user()->archives()->detach($story_id);
            }

            $action = ! $archive ? 'attach' : 'detach';
        }

        $status = $success ? 200 : 500;

        return response()->json(compact('action', 'success', 'message'), $status);
    }

    // change archived story status
    public function archiveStatus(Request $request)
    {
        $story_id = $request->story_id;

        $success = false;
        $message = null;

        if (! $story_id) {
            $message = trans('app.bad_data');
        } else {
            $archive = Auth::user()->archives()->published()->where('story_id', $story_id)->withPivot('is_archive')->first();

            if ($archive) {
                Auth::user()->archives()->syncWithoutDetaching([
                    $story_id => [
                        'is_archive' => ! $archive->pivot->is_archive
                    ]
                ]);
                $success = true;
            } else {
                $message = trans('app.bad_data');
            }
        }

        $status = $success ? 200 : 500;

        return response()->json(compact('success', 'message'), $status);
    }

    // view reading lists
    public function lists(Request $request)
    {
        $lists = $this->saveList->getSaveLists(Auth::user());

        if ($request->ajax()) {
            return $this->listsAjaxPaginate($lists);
        }

        return view('front.library_list', compact('lists'));
    }

    // ajax paginate reading list
    private function listsAjaxPaginate($lists)
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

    // ajax get reading lists
    public function ajaxLists(Request $request)
    {
        $story_id = $request->story_id;
        $lists = $this->saveList->getAjaxLists(Auth::user(), $story_id);
        $is_archived = Auth::user()->archives()->where('story_id', $story_id)->count();

        $content = view('front.ajax_lists', compact('lists', 'is_archived'))->render();

        return response()->json(compact('content'));
    }

    // ajax create reading lists
    public function createList(CreateReadingListRequest $request)
    {
        $source = null;
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
                $source = 'library';
                $data = view('front.items.reading_list', ['list' => $list])->render();
            } else {
                $data = view('front.items.ajax_list', ['list' => $list])->render();
            }

            $success = true;
        } else {
            $success = false;
        }

        $message = $success ? trans('app.list_create_success') : trans('app.permission_denied');

        return response()->json(compact('source', 'success', 'message', 'data'));
    }

    // add story to list
    public function ajaxAddToList(SaveList $list, Request $request)
    {
        $story_id = $request->story_id;

        $action  = null;
        $success = false;
        $message = null;

        if (! $story_id || ! Auth::user()->can('edit', $list)) {
            $message = trans('app.bad_data');
        } else {
            $exists = $list->stories()->published()->where('story_id', $story_id)->first();

            if (! $exists) {
                try {
                    $list->stories()->attach($story_id);
                    $success = true;
                } catch (\Exception $e) {
                    $message = trans('app.bad_data');
                }
            } else {
                $success = true;
                $list->stories()->detach($story_id);
            }

            $action = ! $exists ? 'attach' : 'detach';
        }

        $status = $success ? 200 : 500;

        return response()->json(compact('action', 'success', 'message'), $status);
    }

    // view reading list details
    public function list(SaveList $list, Request $request)
    {
        $list->stories_count = $list->stories()->published()->count();
        $stories = $list->stories()->published()->withCount(['chapters' => function ($q) {
            $q->published();
        }]);

        if ($request->ajax()) {
            $stories = $stories->paginate(config('app.per_page'));

            return $this->ajaxPaginateList($stories);
        }

        $stories = $stories->limit(config('app.per_page'))->get();
        $list->share_text = urlencode(trans('app.a_reading_list_by', [
            'list_name' => $list->name,
            'user_name' => $list->user->login_name
        ]));
        $list->share_url = urlencode(route('list', ['id' => $list->id]));

        return view('front.list_details', compact('list', 'stories'));
    }

    public function updateSync(SaveList $list, Request $request)
    {
        $success = true;
        $select = $request->input('select');

        if (is_array($select) && count($select) > 0) {
            $success = $list->stories()->published()->detach($select);
        }

        return response()->json(compact('success'));
    }

    // ajax reading list stories paginate
    public function ajaxPaginateList($stories)
    {
        $content = '';
        foreach ($stories as $story) {
            $content .= view('front.items.list_story', ['story' => $story])->render();
        }
        $stories = $stories->toArray();
        unset($stories['data']);
        $stories['content'] = $content;

        return response()->json($stories);
    }

    public function update(SaveList $list, EditReadingListRequest $request)
    {
        $success = $list->update([
            'name' => $request->list_name,
        ]);

        return response()->json(compact('success'));
    }

    // ajax delete list
    public function delete(SaveList $list, Request $request)
    {
        $redirect = $request->query('source') == 'details' ? route('lists') : null;

        if (Auth::user()->can('delete', $list)) {
            $success = $list->delete();
            $message = $success ? trans('app.delete_success') : trans('app.unknow_error');
        } else {
            $success = false;
            $message = trans('app.permission_denied');
        }

        return response()->json(compact('success', 'message', 'redirect'));
    }
}
