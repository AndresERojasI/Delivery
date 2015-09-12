<?php

namespace Shipper\Http\Controllers;

use Shipper\User;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AutenticacionController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Esta función es la encargada de autenticar el usuario para
     * realizar la generación del token de autenticación.
     *
     * @param string $username Correo
     * @param string $password Contraseña
     *
     * @return int/bool id del usuario o false si no lo encuentra
     */
    public function authApi($username, $password)
    {
        $credentials = [
            'correo' => $username,
            'password' => $password,
        ];

        // attempt to do the login
        if (Auth::attempt($credentials, true)) {
            return Auth::user()->_id;
        } else {
            return false;
        }
    }

    /**
     * Esta función autentica un usuario en la aplicación.
     *
     * @param string $username Correo
     * @param string $password Contraseña
     *
     * @return User [description]
     */
    public function login(Request $request)
    {
        $credentials = [
            'correo' => $request->input('username', ''),
            'password' => $request->input('password', ''),
        ];

        // attempt to do the login
        if (Auth::attempt($credentials, true)) {
            return \Response::json(
                array(
                    'success' => true,
                    'data' => Auth::user(),
                )
            );
        } else {
            return \Response::json(
                array(
                    'success' => false,
                    'data' => [],
                )
            );
        }
    }
}
