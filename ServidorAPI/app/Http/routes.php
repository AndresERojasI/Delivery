<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

//Constantes
define('DOMINIO', Config::get('app.domain'));
define('VERSION_API', "v".Config::get('app.api_version'));

/**
 * URLs de la página
 */
Route::group(['domain' => DOMINIO], function()
{
    Route::get('/', function (){
		return \Response::json(array('version' => '1.0', 'mensaje' => 'Pronto tendremos una pagina lista...'));
	});
});

/**
 * Rutas de las distintas APIs
 */

//Api para motociclistas
Route::group(['domain' => 'api.'.DOMINIO], function()
{
	//Se asigna el prefijo de la URI para mostrar la version de la API
	Route::group(['prefix' => "/".VERSION_API ], function()
	{
		//Punto Inicio - Solo información
	    Route::get('/', function (){
			return \Response::json(array('version' => VERSION_API, 'mensaje' => 'Bienvenido a la API de Shipper.'));
		});

	    
		
	    Route::group(['prefix' => "auth" ], function()
		{
			//Obtener un token de acceso
			Route::post('/access_token', function() {
			    return Response::json(Authorizer::issueAccessToken());
			});
		});

	    //rutas de usuarios
	    Route::group(['prefix' => "usuarios", 'middleware' => 'oauth-user'], function()
		{
			//Verbos del CRUD de Usuarios
			Route::get('/', ['uses' => 'UsuarioController@listar']); //Listar usuarios
			Route::get('/{campo}/{valor}', ['uses' => 'UsuarioController@buscar']); //Listar usuarios
			Route::post('/', ['uses' => 'UsuarioController@crear']); //Crear Usuario
			Route::put('/{id}', ['uses' => 'UsuarioController@actualizar']); //Actualizar Usuario
			Route::delete('/{id}', ['uses' => 'UsuarioController@eliminar']); //Eliminar Usuario

			//Endpoints para los motociclistas
		    Route::group(['prefix' => "motociclistas" ], function()
			{
				Route::get('/', ['uses' => 'UsuarioController@listarDelivery']); //Listar a todos los motociclistas
				Route::get('/cercanos', ['uses' => 'UsuarioController@listarDeliveryCercanos']); //Listar a todos los motociclistas cercanos
			});

		});

		//rutas de comercios
	    Route::group(['prefix' => "comercios", 'middleware' => 'oauth-user'], function()
		{
			//Verbos del CRUD de Comercios
			Route::get('/{id}', ['uses' => 'ComercioController@listar']); //Listar comercios
			Route::get('/{campo}/{valor}', ['uses' => 'ComercioController@buscar']); //Listar usuarios
			Route::post('/', ['uses' => 'ComercioController@crear']); //Crear Comercio
			Route::put('/{id}', ['uses' => 'ComercioController@actualizar']); //Actualizar Comercio
			Route::delete('/{id}', ['uses' => 'ComercioController@eliminar']); //Eliminar Comercio


			//Rutas de Productos
			Route::group(['prefix' => "{id}/productos"], function()
			{
				//Verbos del CRUD de Productos
				Route::get('/{id}', ['uses' => 'ProductoController@listar']); //Listar producto
				Route::get('/{campo}/{valor}', ['uses' => 'ProductoController@buscar']); //Listar producto
				Route::post('/', ['uses' => 'ProductoController@crear']); //Crear Producto
				Route::put('/{id}', ['uses' => 'ProductoController@actualizar']); //Actualizar Producto
				Route::delete('/{id}', ['uses' => 'ProductoController@eliminar']); //Eliminar Producto
			});
			
			//Rutas de Pedidos
			Route::group(['prefix' => "{id}/pedidos"], function()
			{
				Route::post('/{comercio}', ['uses' => 'PedidoController@solicitarPedido']);//Solicitar un Pedido
				Route::delete('/{idPedido}', ['uses' => 'PedidoController@cancelarPedido']);//Cancelar un Pedido
			});
		});
			   
	});

});