<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class UsersMidelware {

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
		$uri_segments = $request->segments();

		if (!empty($uri_segments) && in_array("api", $uri_segments)) { 
			return $next($request);
		}

		if (\Auth::guest())
		{
			if ($request->ajax()) 
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('http://login.'.\Config::get('app.domain').'/');
			}
		}

		$usuario = \Auth::user();
        if (!empty($usuario))
        {
            //Menú de administrador
            if ($usuario->hasRole('administrador')) {
                \Menu::make('menu_lateral', function($menu){
                    $menu->add('Inicio', 'inicio');
                });
            }

        }else{
            \Redirect::to('/error500');
        }

		return $next($request);
	}

}
