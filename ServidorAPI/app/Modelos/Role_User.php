<?php

namespace Shipper\Modelos;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Role_User extends \Moloquent
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
    protected $collection = 'role_user';

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
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
