<?php

namespace Shipper\Listeners;

use Shipper\Events\EventDisponibilidadDelivery;
use Illuminate\Contracts\Queue\ShouldQueue;

class DisponibilidadDeliveryListener implements ShouldQueue
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
     * @param EventDisponibilidadDelivery $event
     */
    public function handle(\Shipper\Events\EventDisponibilidadDelivery $event)
    {
    }
}
