<?php

namespace Shipper\Modelos;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Cuenta extends \Moloquent
{
    //Bloque de Use
    use SoftDeletes;

    /**
     * Arreglo de fechas para que sean manejadas
     * como un tipo de fecha válido para Mongo
     * Carbon/DateTime.
     *
     * @var array[string]
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $collection = 'cuentas';

    /**
     * Nombre de la conexión, en caso que vayamos a tener 
     * varias BD.
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
        'saldo_actual',
        'estado',
    ];

    protected $guarded = [
        'numero_unico',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Relaciones.
     */
    public function movimientos()
    {
        return $this->hasMany('Shipper\Movimiento');
    }

    /**
     * Validador.
     */
    private $errors;
    private $rules = [
        'saldo_actual' => 'requred|numeric',
        'estado' => 'required|in:activo,suspendido,mora,cancelado',
        'numero_unico' => 'required',
    ];
    private $messages = [];

    public function validate($data)
    {
        // make a new validator object
        $v = \Validator::make($data, $this->rules, $this->messages);

        // check for failure
        if ($v->fails()) {
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

    /**
     * funciones de negocio.
     */
    public function crearNumeroUnico()
    {
        $numero_unico = str_random(10);
        $busqueda = $this->where('numero_unico', '=', $numero_unico) - first();
        if (!is_null($busqueda)) {
            return $numero_unico;
        } else {
            $this->crearNumeroUnico();
        }
    }
}
