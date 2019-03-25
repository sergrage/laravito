<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Entity\User;
use App\Http\Controllers\Controller;
use App\UseCases\Auth\RegisterService;

class RegisterController extends Controller
{
    private $service;
// тут передается экземпляр класса сервиса в данный контроллер через конструктор
// также и в UsersController
    public function __construct(RegisterService $service)
    {
        $this->middleware('guest');
        $this->service = $service;
    }


// этот метод дернут из RegisterUsers.php
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $this->service->register($request);

        return redirect()->route('login')
            ->with('success', 'Check your email and click on the link to verify.');
    }

    public function verify($token)
    {
        if (!$user = User::where('verify_token', $token)->first()) {
            return redirect()->route('login')
                ->with('error', 'Sorry your link cannot be identified.');
        }

        try {
// тут передается не пользователь, а тольок его id, чтобы не менять  user в этом методе. В сервесе он будет взят из базы заново. тоже самое и в UsersController - там verify на кнопку в админке кинут.
            $this->service->verify($user->id);
            return redirect()->route('login')->with('success', 'Your e-mail is verified. You can now login.');
        } catch (\DomainException $e) {
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }
}
