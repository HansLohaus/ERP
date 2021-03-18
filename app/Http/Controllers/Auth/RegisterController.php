<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\VerifyUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Activar al usuario
     * @param  string $token 
     */
    public function verifyUser(Request $request, $token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if( isset($verifyUser) ){

            // Se obtiene al usuario asociado al token
            $user = $verifyUser->user;

            // Si se requiere cargar la vista para modificar la contraseña
            if ($request->isMethod("get")) {
                return view("auth.passwords.activate",[
                    "token" => $token,
                    "user" => $user
                ]);
            }
            // Si se requiere de activar la cuenta y modificar
            // por primera vez la contraseña
            else if ($request->isMethod("post")) {

                // Se debe validar el password
                $validator = Validator::make($request->all(), [
                    "password" => "required|same:password_confirmation",
                    "password_confirmation" => "required",
                ]);

                if ($validator->fails()) {

                    $request->session()->flash('alert-danger', 'Las contraseñas que usted ingresó no coinciden.');
                    return back()->withInput()
                        ->withErrors($validator);
                }

                // Si el usuario no esta activo
                if($user->estado !== 1) {

                    // Se genera un log de activacion
                    $verifyUser->user->log($request,"Activa su cuenta de usuario");

                    // Se actualiza la contraseña del usuario
                    $verifyUser->user->password = bcrypt($request->input("password"));

                    // Se procede a activar al usuario
                    $verifyUser->user->estado = 1;
                    
                    $verifyUser->user->save();

                    $request->session()->flash('alert-success', 'Su correo electrónico está verificado Ahora puede iniciar sesión.');
                } else {

                    // El usuario ya esta activo
                    $request->session()->flash('alert-success', "Su correo electrónico ya está verificado. Ahora puede iniciar sesión.");
                }
                return redirect('/login');
            }
        } else {
            $request->session()->flash('alert-warning', "Lo siento, su correo electrónico no puede ser identificado.");
            return redirect('/login');
        }
              
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        $request->session()->flash('alert-success', 'Le enviamos un código de activación. Verifique su correo electrónico y haga clic en el enlace para verificar.');
        return redirect('/login');
    }
}
