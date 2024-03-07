<?php

namespace App\Listeners;

use App\Events\DatabaseUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateGeoJSON
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
     * @param  \App\Events\DatabaseUpdated  $event
     * @return void
     */
    public function handle(DatabaseUpdated $event)
    {
        //
    }
}
