<?php 
/**
 * Esta clase representa la lógica de controladores para las
 * funcionalidades de los Usuarios
 */
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UsuarioController extends Controller {

	/**
	 * Listar Usuarios
	 * 
	 * @return Array[User]
	 */
	public function listar(){
		
	}

	/**
	 * Buscar un usuario mediante un campo y valor
	 * 
	 * @param  string $campo El campo de la tabla por la que se va a realizar la búsqueda
	 * @param  string $valor El valor mediante el cual se filtra la búsqueda
	 * @return User/Null     Usuario encontrado
	 */
	public function buscar($campo, $valor){

	}

	/**
	 * Crear un usuario
	 * 
	 * @return User Usuario creado
	 */
	public function crear(){

	}

	/**
	 * Actualizar un usuario
	 * 
	 * @param  string $id ID del usuario a editar
	 * @return user       Usuario actualizado
	 */
	public function actualizar($id){

	}

	/**
	 * Eliminar Usuario
	 * 
	 * @param  string $id ID del usuario a eliminar
	 * @return Bool       Retorna true si ha sido eliminado y false an caos contrario
	 */
	public function eliminar($id){

	}
}
