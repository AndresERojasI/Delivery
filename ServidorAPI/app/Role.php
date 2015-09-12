<?php namespace Shipper;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {
	//Bloque de Use
	use SoftDeletes;

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
	protected $collection =  'roles';

	/**
	 * Nombre de la conexión, en caso que vayamos a tener 
	 * varias BD
	 * 
	 * @var string
	 */
	protected $connection = 'mongodb';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'display_name', 'description'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * Rules set array
	 * @var array
	 */
	protected $rules = array(
		'name' => 'required|min:3|max:20', 
		'display_name' => 'required|min:3|max:20', 
		'description' => 'required|max:200'
	);

	protected $messages = [
    	'required' => 'El campo :attribute es obligatorio.',
    	'min' => 'El campo :attribute es demasiado corto.',
    	'max' => 'El campo :attribute es demasiado largo.',
	];

	/**
	 * Validador
	 */
	private $errors;

    public function validate($data)
    {
        // make a new validator object
        $v = \Validator::make($data, $this->rules, $this->messages);

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
}
