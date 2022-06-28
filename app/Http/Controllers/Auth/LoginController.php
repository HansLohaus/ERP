<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function username() {
        return "username";
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->estado !== 1) {
            auth()->logout();
            $request->session()->flash('alert-warning', 'Debes confirmar tu cuenta, Le hemos enviado un código de activación, verifique su correo electrónico.');
            return back();
        }
        return redirect()->intended($this->redirectPath());
    }
}
