<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use App\Models\UserProfile;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepo->all();

        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $user = $this->userRepo;
        $user->create([
            'full_name' => $request->get('name'),
            'login_name' => $request->get('loginname'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => ($request->get('role') != 'admin') ? 0 : 1,
        ]);

        return redirect('/admin/users/create')->with('status', __('tran.user_create_status'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepo->findOrFail($id);

        return view('backend.users.update', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('profile')->findOrFail($id);

        return view('backend.users.update', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UserUpdateRequest $request)
    {
        $user = $this->userRepo->findOrFail($id);
        $user->full_name = $request->get('name');
        $user->login_name = $request->get('loginname');
        $user->email = $request->get('email');
        $password = $request->get('password');
        if ($password != '') {
            $user->password = Hash::make($password);
        }
        $user->role = ($request->get('role') != 'admin') ? 0 : 1;
        $user->is_banned = ($request->get('ban') != 'no') ? 1 : 0;
        if ($request->hasFile('avatar_file')) {
            $avatar = uploadFile(
                $request->file('avatar_file'),
                config('app.avatar_path'),
                config('app.avatar_sizes')
            );
            $user->avatar = $avatar;
        }
        
        if ($request->hasFile('cover_image')) {
            $user_cover = uploadFile(
                $request->file('cover_image'),
                config('app.user_cover_path'),
                config('app.user_cover_sizes')
            );
            $user->cover_image = $user_cover;
        }
        $user->save();
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'address' => $request->get('address'),
                'about' => $request->get('about'),
            ]
        );

        return redirect()->route('update_user', [$id])->with('status', __('tran.user_update_status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userRepo->findOrFail($id);
        $user->delete();

        return redirect('/admin/users')->with('status', __('tran.user_delete_status'));
    }
}
