<?php

namespace Shipper\Events;

use Shipper\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventoCambioUbicacion extends Event
{
    use SerializesModels;

    /**
     * Bloque de atributos del Evento
     */
    public $posicion;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Shipper\Geoposicion $posicion)
    {
        $this->posicion = $posicion;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [''];
    }
}
