<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		

		if ($this->auth->guest())
		{
			$uri_segments = $request->segments();
			$subdominio = $request->root();
			$subdominio = str_replace('http://', '', $subdominio);
			$subdominio = explode('.', $subdominio);
			$subdominio = $subdominio['0'];

			if ($subdominio === "api") {
				return \Response::json(array('success' => false, 'message' => 'No se ha podido iniciar sesión'));
			}
			
			return redirect()->guest('auth/login');
		}

		return $next($request);
	}

}
