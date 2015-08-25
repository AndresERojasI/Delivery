<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

$dominio = Config::get('app.domain');

/**
 * URLs de la página
 */
Route::group(['domain' => $dominio], function()
{

    Route::get('/', function (){
		return \Response::json(array('version' => '1.0', 'mensaje' => 'Pronto tendremos una pagina lista...'));
	});

});

/**
 * Rutas de las distintas APIs
 */

//Api para motociclistas
Route::group(['domain' => 'api.'.$dominio], function()
{
	/**
	 * Punto Inicio - Solo información
	 */
    Route::get('/', function (){
		return \Response::json(array('version' => '1.0', 'mensaje' => 'Bienvenido a la API de Shipper.'));
	});


    Route::post('/login', function (){
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

	});

	Route::post('/buscarUsuario', function (){
		// create our user data for the authentication
		$email = \Request::input('correo');
		$usuario = \App\User::where('correo', '=', $email)->first();

		if (!is_null($usuario)) {
			return \Response::json(array('success' => true, 'usuario' => $usuario));
		}else{
			return \Response::json(array('success' => false));
		}

	});

	Route::post('/buscarUsuarioID', function (){
		// create our user data for the authentication
		$id = \Request::input('id');
		$usuario = \App\User::where('_id', '=', $id)->first();

		if (!is_null($usuario)) {
			return \Response::json(array('success' => true, 'usuario' => $usuario));
		}else{
			return \Response::json(array('success' => false));
		}

	});

	Route::post('/registrarUsuario', function (){
		$data = \Request::all();
		$usuario = \App\User::where('correo', '=', $data['correo'])->first();
		if (is_null($usuario)) {

			$usuario = new \App\User($data);
					
			if ($usuario->validate($data)) {
				$usuario->contrasena = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 1) . substr(str_shuffle('aBcEeFgHiJkLmNoPqRstUvWxYz0123456789'),0, 8);
				$usuario->save();
				$resultado = Mail::send('emails.register', ['usuario' => $usuario->correo, 'contrasena' => $usuario->contrasena], function($message) use( &$usuario)
				{
					$message->from('andres.rojas@solidoic.in', 'Shipper Admin');
				    $message->to($usuario->correo, $usuario->nombres)->subject('Bienvenido a Shipper');
				});

				return \Response::json(array('success' => true, 'id' => $usuario->_id, 'usuario' => $usuario, 'resultado' => $resultado));
			}else{
				return \Response::json(array('success' => false));
			}
		}else{
			return \Response::json(array('success' => false, 'existe' => true));
		}
			
	});

	Route::post('/actualizarUsuario', function (){
		$data = \Request::all();
		
		$usuario = \App\User::where('_id', '=', $data['_id'])->first();
		if (!is_null($usuario)) {
			if ($usuario->validate($data)) {

				$usuario->update($data);
				return \Response::json(array('success' => true, 'id' => $usuario->_id, 'usuario' => $usuario));
			}else{
				return \Response::json(array('success' => false));
			}
		}else{
			return \Response::json(array('success' => false, 'existe' => true));
		}
			
	});

});