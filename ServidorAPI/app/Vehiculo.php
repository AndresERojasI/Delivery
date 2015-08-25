<?php namespace App;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Vehiculo extends \Moloquent {

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
	protected $collection =  'vehiculos';

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
	protected $fillable = [
		'tipo',
		'placa',
		'foto',
		'caracteristicas'
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
	private $messages = [];

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