<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SocialUserRepository;
use Socialite;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $providers = [
        'facebook',
        'github',
        'google',
    ];

    private $social_user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SocialUserRepository $social_user)
    {
        $this->middleware('guest')->except('logout');
        $this->social_user = $social_user;
    }

    public function showLoginForm()
    {
        return view('front.login');
    }

    protected function credentials(Request $request)
    {
        $login_type = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'login_name';
        $email = $login_name = $request->email;
        $password = $request->password;

        return compact($login_type, 'password');
    }
    
    // Social login
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, $this->providers)) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider, Request $request)
    {
        if (!in_array($provider, $this->providers)) {
            abort(404);
        }

        if ($provider == 'facebook') {
            if ($request->query('code') && $request->query('state')) {
                $provider_user = Socialite::driver($provider)
                    ->fields(['name', 'email', 'gender', 'verified', 'picture.width(720).height(720)'])
                    ->user();
            } else {
                return redirect()->route('login')->withErrors([
                    $this->username() => [trans('app.login_with_socail_failed')]
                ]);
            }
        }
        if ($provider == 'google') {
            if ($request->query('code') && $request->query('state')) {
                $provider_user = Socialite::driver($provider)->user();
            } else {
                return redirect()->route('login')->withErrors([
                    $this->username() => [trans('app.login_with_socail_failed')]
                ]);
            }
        }
        $user = $this->social_user->getOrCreate($provider_user, $provider);

        if (!$user) {
            abort(403);
        }

        auth()->login($user, true);

        return redirect()->route('home');
    }
}
