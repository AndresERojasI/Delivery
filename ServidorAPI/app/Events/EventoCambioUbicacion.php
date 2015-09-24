<?php

namespace Shipper\Events;

use Shipper\Modelos\User;
use Shipper\Modelos\Geoposicion;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventoCambioUbicacion extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Bloque de atributos del Evento.
     */
    public $usuario;
    public $geoposicion;

    /**
     * Create a new event instance.
     */
    public function __construct(User $usuario, Geoposicion $geoposicion)
    {
        $this->usuario = $usuario;
        $this->geoposicion = $geoposicion;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            'geoposicion-motociclistas',
        ];
    }
}
