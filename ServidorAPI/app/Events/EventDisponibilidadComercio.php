<?php

namespace Shipper\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Shipper\Modelos\User;

class EventDisponibilidadComercio extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $usuario;

    /**
     * Create a new event instance.
     */
    public function __construct(User $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            'disponibilidad-comercio',
            'disponibilidad-comercio-'.$this->usuario->_id,
        ];
    }
}
