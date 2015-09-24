<?php

namespace Shipper\Listeners;

use Shipper\Events\EventDisponibilidadComercio;
use Illuminate\Contracts\Queue\ShouldQueue;

class DisponibilidadComercioListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param EventDisponibilidadComercio $event
     */
    public function handle(\Shipper\Events\EventDisponibilidadComercio $event)
    {
    }
}
