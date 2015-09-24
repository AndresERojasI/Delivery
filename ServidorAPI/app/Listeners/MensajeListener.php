<?php

namespace Shipper\Listeners;

use Shipper\Events\Mensaje;
use Illuminate\Contracts\Queue\ShouldQueue;

class MensajeListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Mensaje $event
     */
    public function handle(\Shipper\Events\EventMensaje $event)
    {
        //
    }
}
