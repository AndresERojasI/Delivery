<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends \Moloquent implements AuthenticatableContract, CanResetPasswordContract {

	//Bloque de Use
	use Authenticatable, CanResetPassword;
	use SoftDeletes;
	use EntrustUserTrait;

	/**
	 * Llave primaria de la tabla
	 * 
	 * @var string
	 */
	protected $primaryKey = '_id';

	/**
	 * Arreglo de fechas para que sean manejadas
	 * como un tipo de fecha válido para Mongo
	 * Carbon/DateTime
	 * 
	 * @var array[string]
	 */
	protected $dates = ['deleted_at', 'last_login'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		//Datos personales
		'nombres',
		'apellidos',
		'celular',
		'avatar',
		'pais',
		'ciudad',
		'direccion',
		//datos autenticación
		'correo',
		'contrasena',
		'tipo_usuario',
		'fb_id',
		'tw_id',
		'estado',
		//Datos Gamification
		'puntos'
    ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
		'contrasena'
	];

	/**
	 * Relaciones
	 */
	public function badges(){
		return $this->hasMany('App\Badges');
	}

	public function vehiculo(){
		return $this->hasOne('App\Vehiculo');
	}

	public function configuracion(){
		return $this->hasOne('App\Configuracion');
	}

	public function geoposicion(){
		return $this->hasOne('App\Geoposicion');
	}

	public function cuenta(){
		return $this->hasOne('App\Cuenta');
	}

	/**
	 * Validador
	 */
	private $errors;
	private $rules = [
		//Datos personales
		'nombres' =>  'required|min:2|max:80|alpha_num',
		'apellidos' => 'required|min:2|max:80|alpha_num',
		'celular' => 'required|size:10|integer|unique:users,celular',
		'pais' => 'required',
		'ciudad'  => 'required',
		'direccion'  => 'required',
		//datos autenticación
		'correo'  => 'required|email|unique:users,correo',
		'contrasena' => 'required|min:8|max:64',
		'tipo_usuario' => 'required|in:admin,delivery,user,comercio',
		'estado' => 'required|in:pendiente,activo,suspendido,retirado',
		//Datos Gamification
		'puntos'  => 'required|integer'
	];
	private $messages = [];

    public function validate($data)
    {
        // make a new validator object
        $v = \Validator::make($data, $this->rules);

        // check for failure
        if ($v->fails())
        {
            // set errors and return false
            $this->errors = $v->errors();
            return false; 
        }

        // validation pass
        return true;
    }

    public function errors()	
    {
        return $this->errors;
    }

    public function getAuthIdentifier()
	{
	    return $this->correo;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
	    return $this->contrasena;
	}
}
