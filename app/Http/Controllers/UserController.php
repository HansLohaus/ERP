<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Modelos
use Spatie\Permission\Models\Role;
use App\User;
use App\VerifyUser;
use App\Logs;

// Emails
use App\Mail\ActivarCuenta;

// Clases
use Validator;
use File;
use Mail;
use Log;

class UserController extends Controller
{
    //-------------------------------------------------------------------------------
	// CONSTRUCTOR : REQUIERE AUTENTIFICACIÓN DEL USUARIO
	//-------------------------------------------------------------------------------
	public function __construct() {

		// El usuario debe estar logueado
		$this->middleware('auth');

		// Se agregan restricciones de permisos sobre los metodos
        $this->middleware('permission:show users', ['only' => [
            'index',
            'show'
        ]]);
        $this->middleware('permission:manage users', ['only' => [
			'store',
			'update',
			'destroy'
        ]]);
	}

	//-------------------------------------------------------------------------------
	// METODOS DEL CONTROLADOR
	//-------------------------------------------------------------------------------
	
	/**
	 * Lista todos los usuarios
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {

		Auth::user()->log("Ingresa a la vista de usuarios");

		// Se obtienen todos los usuarios del sistema
		// excepto los eliminados logicamente
		$usuarios = User::get();
		$roles = Role::all();

		// Se obtiene la vista con todos los usuarios
		return view("usuarios",[
			"usuarios" => $usuarios,
			"roles" => $roles
		]);
	}

	/**
	 * Ver los datos de un usuario en específico
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id ID del usuario asociado
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id) {

		// Se obtiene el usuario
		$usuario = User::find($id);

		// Si el usuario existe y no esta eliminado
		if ($usuario !== null) {

			Auth::user()->log("Ve los datos del usuario ".$usuario->name);

			// Se verifica que la imagen exista
			if (File::exists(public_path('assets/images/users/'.$id.'.jpg'))) {
				$usuario->foto = asset('assets/images/users/'.$id.'.jpg');
			} else {
				$usuario->foto = null;
			}

			// Se obtiene la vista con todos los usuarios
			return response()->json($usuario);
		} else {

			// No se obtiene nada
			return response()->json(null);
		}
	}

	/**
	 * Crea un nuevo usuario
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		// Se obtiene el usuario ingresado
		$username = $request->input("username");
		$name = $request->input('name'); 
		$password = $username."-,".date("Y");
		$email = $request->input('email');
		$rol = $request->input("rol");
		
		// Foto de perfil
		$foto = $request->file("foto");

		// El email debe ser unico
		$validator = Validator::make($request->all(), [
			"email" => "unique:users",
			"username" => "unique:users"
		]);

		// Si el validador falla, se muestra el error
		if ($validator->fails()) {
			$request->session()->flash('alert-danger', 'El email '.$email.' ya existe en el sistema.');
			return back()->withInput()
				->withErrors($validator);
		}

		// Se agrega el usuario si no existe
		$usuario = User::firstOrCreate([
			'username' => $username
		],[
			'username' => $username,
			'name' => $name, 
			'password' => bcrypt($password),
			'email' => $email,
			'estado' => 2,
		]);

		// Se sincroniza el rol
		$usuario->assignRole($rol);

		Auth::user()->log("Crea el usuario ".$username);

		// Si el usuario fue creado
		if ($usuario->wasRecentlyCreated) {

			// Si hay foto ingresada, se guarda
			if ($foto !== null) {
				// La foto debe ser una imagen
				$ext = $foto->extension();
				if ($ext == "jpeg" || $ext == "jpg") {
					$foto->move(public_path('assets/images/users'), $usuario->id.'.jpg');
				}
			}

			// Se manda la notificacion al usuario si este posee email
			if ($usuario->email !== "") {
				$verifyUser = VerifyUser::create([
					'user_id' => $usuario->id,
					'token' => str_random(40)
				]);
				Mail::to($usuario->email)->send(new ActivarCuenta($usuario));
			}
			$request->session()->flash('alert-success', 'El Usuario '.$username.' ha sido agregado con éxito.');
		} else {
			$request->session()->flash('alert-warning', 'El usuario '.$username.' ya existe en el sistema.');
		}
		return back()->withInput();
	}

	/**
	 * Edita un usuario
	 */
	public function update(Request $request, $id) {

		// Se obtiene el usuario ingresado
		$username = $request->input("username");
		$name = $request->input('name');
		$email = $request->input('email');
		$rol = $request->input("rol");
		
		// Foto de perfil
		$foto = $request->file("foto");

		// El nombre del usuario no se debe repetir
		$usuario = User::where("username",$username)->first();
		if ($usuario == null || ($usuario !== null && $usuario->id == $id)) {

			// Se edita el usuario
			Auth::user()->log("Edita el usuario ".$username);
			User::where("id",$id)
			->update([
				'username' => $username, 
				'name' => $name,
				'email' => $email
			]);
			$usuario->assignRole($rol);

			// Si hay foto ingresada, se guarda
			if ($foto !== null) {
				// La foto debe ser una imagen
				$ext = $foto->extension();
				if ($ext == "jpeg" || $ext == "jpg") {
					$foto->move(public_path('assets/images/users'), $id.'.jpg');
				}
			} else {
				File::delete(public_path('assets/images/users/'.$id.'.jpg'));
			}
			$request->session()->flash('alert-success', 'Usuario modificado con éxito.');
		} else {
			$request->session()->flash('alert-warning', 'El usuario '.$username.' ya existe en el sistema.');
		}
		return back()->withInput();
	}

	/**
	 * Eliminar un usuario
	 */
	public function destroy(Request $request, $id) {

		// El usuario debe ser distinto al actual
		if ((string)Auth::user()->id !== (string)$id) {

			$usuario = User::find($id);
			Auth::user()->log("Elimina el usuario ".$usuario->username);
			$request->session()->flash('alert-success', 'El Usuario '.$usuario->username.' ha sido eliminado con éxito.');
			$usuario->delete();

		} else {
			$request->session()->flash('alert-danger', 'Ud no se puede eliminar del sistema.');
		}

		return back()->withInput();
	}

	/**
	 * Carga la vista de logs
	 */
	public function verLogs(Request $request) {
		if (Auth::user()->hasRole("superadmin")) {
			$logs = Logs::with("usuario")->get();
			return view("logs",[
				"logs" => $logs
			]);
		} else {
			return back()->withInput();
		}
	}

	/**
	 * Carga la vista de ayuda con todos los manuales
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function ayuda(Request $request) {
		Auth::user()->log("Entra a la vista de ayuda");
		return view("ayuda");
	}

	/**
	 * Descarga los manuales situados en storage
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function manuales(Request $request) {

		// Se obtiene el nombre del manual que se desea descargar
		$archivo = $request->input("archivo");

		// Se obtiene el path de la carpeta que contiene los manuales
		$path = storage_path("app/manuales/".$archivo.".pdf");

		// Se verifica que el archivo exista
		if (File::exists($path)) {
			Auth::user()->log("Descarga manual ".$archivo.".pdf");
			return response()->download($path,$archivo.".pdf",[
				'Content-type' => 'application/pdf',
				'charset' => 'utf-8'
			]);
		} else {
			$request->session()->flash('alert-danger', 'Error al descargar el archivo, el archivo no existe.');
			return back()->withInput();
		}
	}
}
