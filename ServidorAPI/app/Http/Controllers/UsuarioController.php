<?php

/**
 * Esta clase representa la lógica de controladores para las
 * funcionalidades de los Usuarios.
 */
namespace Shipper\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Listar Usuarios.
     *
     * @return Array[User] Lista de Usuarios
     */
    public function listar(Request $request)
    {
        //modelo general
        $userModel = new \Shipper\Modelos\User();

        //limit y offset
        $offset = $request->input('offset', false);
        $limit = $request->input('limit', false);
        $total = $userModel->count();

        //limit
        if ($limit && $offset) {
            $cant_paginas = intval($total / $limit);
            $limit = intval($limit);
            $offset = intval($offset);

            $userModel->take($limit)->skip($offset);

            //Se retorna la respuesta con la siguiente pagina Hateoas
            return \Response::json(array(
                'success' => true,
                'data' => $userModel->get(),
                'next_page' => array(
                    'limit' => $limit,
                    'offset' => ($limit + $offset),
                    'total' => $total,
                    'cant_paginas' => $cant_paginas,
                ),
            ));
        }

        return \Response::json(array(
            'success' => true,
            'data' => $userModel->all(),
        ));
    }

    /**
     * Buscar un usuario mediante un campo y valor.
     *
     * @param string $campo El campo de la tabla por la que se va a realizar la búsqueda
     * @param string $valor El valor mediante el cual se filtra la búsqueda
     *
     * @return User/Null Usuario encontrado
     */
    public function buscar(Request $request, $campo, $valor)
    {
        //verificamos si cumple los requisitos
        if (!is_null($campo) || !is_null($valor)) {
            //modelo general
            $userModel = new \Shipper\Modelos\User();

            //limit y offset
            $offset = $request->input('offset', false);
            $limit = $request->input('limit', false);
            $total = $userModel->count();

            //limit
            if ($limit && $offset) {
                $cant_paginas = intval($total / $limit);
                $limit = intval($limit);
                $offset = intval($offset);

                $userModel->where($campo, '=', $valor)->take($limit)->skip($offset);

                //Se retorna la respuesta con la siguiente pagina Hateoas
                return \Response::json(array(
                    'success' => true,
                    'data' => $userModel->get(),
                    'next_page' => array(
                        'limit' => $limit,
                        'offset' => ($limit + $offset),
                        'total' => $total,
                        'cant_paginas' => $cant_paginas,
                    ),
                ));
            }

            return \Response::json(array(
                'success' => true,
                'data' => $userModel->where($campo, '=', $valor)->get(),
            ));
        } else {
            return \Response::json(array('success' => false, 'message' => 'No se han ingresado los suficientes criterios de búsqueda'));
        }
    }

    /**
     * Crear un usuario.
     *
     * @return User Usuario creado
     */
    public function crear(Request $request)
    {
        $data = $request->all();

        if (isset($data['correo'])) {
            $usuario = \Shipper\Modelos\User::where('correo', '=', $data['correo'])->first();

            if (is_null($usuario)) {
                $usuario = new \Shipper\Modelos\User();

                if ($usuario->validate($data)) {
                    $usuario->contrasena = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 1).substr(str_shuffle('aBcEeFgHiJkLmNoPqRstUvWxYz0123456789'), 0, 8);
                    $usuario->create($data);

                    $resultado = Mail::send('emails.register', ['usuario' => $usuario->correo, 'contrasena' => $usuario->contrasena], function ($message) use (&$usuario) {
                        $message->from('andres.rojas@solidoic.in', 'Shipper Admin');
                        $message->to($usuario->correo, $usuario->nombres)->subject('Bienvenido a Shipper');
                    });

                    return \Response::json(array('success' => true, 'data' => $usuario));
                } else {
                    return \Response::json(array('success' => false, 'message' => 'Los datos ingresados no son válidos'));
                }
            } else {
                return \Response::json(array('success' => false, 'message' => 'El usuario ya existe'));
            }
        } else {
            return \Response::json(array('success' => false, 'message' => 'No has ingresado un correo'));
        }
    }

    /**
     * Actualizar un usuario.
     *
     * @param string $id ID del usuario a editar
     *
     * @return user Usuario actualizado
     */
    public function actualizar(Request $request, $id)
    {
        $data = $request->all();
        $usuario = \Shipper\Modelos\User::find($id);

        if ($usuario->validate($data)) {
            $usuario->update($data);

            return \Response::json(array('success' => true, 'data' => $usuario));
        } else {
            return \Response::json(array('success' => false, 'message' => 'Los datos ingresados no son válidos'));
        }
    }

    /**
     * Eliminar Usuario.
     *
     * @param string $id ID del usuario a eliminar
     *
     * @return Bool Retorna true si ha sido eliminado y false an caos contrario
     */
    public function eliminar(Request $request, $id)
    {
        $usuario = \Shipper\Modelos\User::find($id);

        if (!is_null($usuario)) {
            $usuario->delete();

            return \Response::json(array('success' => true));
        } else {
            return \Response::json(array('success' => false, 'message' => 'El usuario a eliminar no existe'));
        }
    }

    /**
     * Listar los motociclistas afiliados.
     *
     * @return Array[User] Lista de Motociclistas
     */
    public function listarDelivery(Request $request)
    {
        //modelo general
        $userModel = new \Shipper\Modelos\User();

        //limit y offset
        $offset = $request->input('offset', false);
        $limit = $request->input('limit', false);
        $total = $userModel->count();
        $cant_paginas = intval($total / $limit);

        //limit
        if ($limit && $offset) {
            $limit = intval($limit);
            $offset = intval($offset);

            $userModel->where('tipo_usuario', '=', 'delivery')->take($limit)->skip($offset);

            //Se retorna la respuesta con la siguiente pagina Hateoas
            return \Response::json(array(
                'success' => true,
                'data' => $userModel->get(),
                'next_page' => array(
                    'limit' => $limit,
                    'offset' => ($limit + $offset),
                    'total' => $total,
                    'cant_paginas' => $cant_paginas,
                ),
            ));
        }

        return \Response::json(array(
            'success' => true,
            'data' => $userModel->where('tipo_usuario', '=', 'delivery')->get(),
        ));
    }

    /**
     * Listar los motociclistas en estado activos y cercanos a una lat/long.
     *
     * @return Array[User] Lista de Motociclistas
     */
    public function listarDeliveryCercanos(Request $request)
    {
        //TODO: logica con Arcgis
    }

    /**
     * [cambiarEstado description].
     *
     * @param Request $request [description]
     * @param [type]  $id      [description]
     *
     * @return [type] [description]
     */
    public function cambiarEstado(Request $request, $id)
    {
        $usuario = \Shipper\Modelos\User::find($id);
        if (!is_null($usuario)) {
            $usuario->disponible = $request->input('estado', false);
            $usuario->update();
            try {
                //if ($usuario->tipo_usuario === 'delivery') {
                if ($usuario->tipo_usuario === 'Admin') {
                    \Event::fire(new \Shipper\Events\EventDisponibilidadDelivery($usuario));
                } elseif ($usuario->tipo_usuario === 'comercio') {
                    \Event::fire(new \Shipper\Events\EventDisponibilidadComercio($usuario));
                }
            } catch (Exception $e) {
                return \Response::json(array(
                    'success' => false,
                    'data' => $e,
                ));
            }

            return \Response::json(array(
                'success' => true,
                'data' => [],
            ));
        } else {
            return \Response::json(array(
                'success' => false,
                'data' => [],
            ));
        }
    }

    /**
     * [cambiarGeoposicion description].
     *
     * @return [type] [description]
     */
    public function cambiarGeoposicion(Request $request, $id)
    {
        $usuario = \Shipper\Modelos\User::find($id);
        $latitud = $request->input('latitud', false);
        $longitud = $request->input('longitud', false);
        if (!is_null($usuario) && $latitud && $longitud) {
            $geoposicion = new \Shipper\Modelos\Geoposicion(array(
                    'latitud' => $latitud,
                    'longitud' => $longitud,
            ));

            $usuario->geoposicion()->save($geoposicion);
            $usuario->update();

            \Event::fire(new \Shipper\Events\EventoCambioUbicacion($usuario, $geoposicion));

            return \Response::json(array(
                'success' => true,
                'data' => [],
            ));
        } else {
            return \Response::json(array(
                'success' => false,
                'data' => [],
            ));
        }
    }
}
