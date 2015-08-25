<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AutenticacionController extends Controller {

	public function loginDelivery(){
		// create our user data for the authentication
		$email    = \Request::input('correo');
		$password = \Request::input('contrasena');
		$usuario = \App\User::where('correo', '=', $email)->first();
	    // attempt to do the login
	    // attempt(array $credentials = array(), bool $remember = false, bool $login = true)
		if ($usuario->contrasena === $password) {
			$return = \Request::input('return');
			if (isset($return) && !empty($return) && !is_null($return)) {
				return \Response::json(array('success' => true, 'message' => 'Bienvenido a la aplicación', 'user' => $usuario));
			}else{
				return \Response::json(array('success' => true, 'message' => 'Bienvenido a la aplicación'));
			}
		}else{
			return \Response::json(array('success' => false, 'message' => 'No se ha podido iniciar sesión'));
		}
	}

}
