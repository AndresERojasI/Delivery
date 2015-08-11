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
	protected $dates = ['deleted_at'];

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
	      'nombres',
	      'apellidos',
	      'correo',
	      'celular',
	      'avatar_principal',
	      'contrasena',
	      'pais',
	      'puntos',
	      'configuracion',
	      'contactos',
	      'sincronizado',
	      'foto_publica',
	      'vehiculo'
    ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Validador
	 */
	private $errors;
	private $rules = [];

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
	    return $this->_id;
	}

	public function contactosRel(){
		return  $this->hasMany('\App\User');
	}

	public static function limpiarTelefono($celular){
		if (strlen($celular) >= 10) {
			$celular = filter_var($celular, FILTER_SANITIZE_NUMBER_INT);
			$celular = str_replace(array('+', '-', ' '), array('','',''), $celular);
			if (strlen($celular) >= 10) {
				$celular = substr($celular, -10);
				return $celular;
			}else{
				return $celular;
			}
		}else{
			return $celular;
		}
	}
}
