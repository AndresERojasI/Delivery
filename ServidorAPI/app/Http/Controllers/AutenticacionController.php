<?php namespace App\Http\Controllers;

use App\User;
use Validator;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;

class AutenticacionController extends Controller {
	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	public function login($username, $password){
		$credentials = [
			'correo'    => $username,
			'password' => $password,
		];

	    // attempt to do the login
		if (Auth::attempt($credentials, true)) {
			return Auth::user()->_id;
		}else{
			return false;
		}
	}
}

