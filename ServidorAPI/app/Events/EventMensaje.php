<?php

namespace Shipper\Events;

use Shipper\Events\EventMensaje;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EventMensaje extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $mensaje;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['test-channel'];
    }
}
