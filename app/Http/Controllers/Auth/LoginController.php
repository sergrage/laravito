<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use App\Entity\User;

class LoginController extends Controller
{

    use ThrottlesLogins;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {

        // проверка на количество попыток залогинивания

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }
        // http://laravel.su/docs/5.0/authentication - тут про attempt и intended
        // ищет пользователя по полям.
        $authenticate = Auth::attempt(
            // извлекает из request только указанные поля
            $request->only(['email', 'password']),
            $request->filled('remember')
        );

        if ($authenticate) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            $user = Auth::user();
            if ($user->status !== User::STATUS_ACTIVE) {
                Auth::logout();
                return back()->with('error', 'You need to confirm your account. Please check your email.');
            }
            return redirect()->intended(route('cabinet.home'));
        }

        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    //  public function verify(Request $request)
    // {
    //     if ($this->hasTooManyLoginAttempts($request)) {
    //         $this->fireLockoutEvent($request);
    //         $this->sendLockoutResponse($request);
    //     }

    //     $this->validate($request, [
    //         'token' => 'required|string',
    //     ]);

    //     if (!$session = $request->session()->get('auth')) {
    //         throw new BadRequestHttpException('Missing token info.');
    //     }

    //     * @var User $user 
    //     $user = User::findOrFail($session['id']);

    //     if ($request['token'] === $session['token']) {
    //         $request->session()->flush();
    //         $this->clearLoginAttempts($request);
    //         Auth::login($user, $session['remember']);
    //         return redirect()->intended(route('cabinet.home'));
    //     }

    //     $this->incrementLoginAttempts($request);

    //     throw ValidationException::withMessages(['token' => ['Invalid auth token.']]);
    // }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('home');
    }

    public function username()
    {
        return 'email';
    }

// Этот метод дернут из trait AuthenticatesUsers/
// Если пользователь не подтвердил почту, перейдя по ссылке, то его редиректяд назад.
// Если подтвердил, то redirectPath() на protected $redirectTo = '/cabinet';

}
