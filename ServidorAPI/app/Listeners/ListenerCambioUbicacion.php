<?php

namespace Shipper\Listeners;

use Shipper\Events\EventoCambioUbicacion;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ListenerCambioUbicacion
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EventoCambioUbicacion  $event
     * @return void
     */
    public function handle(EventoCambioUbicacion $event)
    {
        //
    }
}
