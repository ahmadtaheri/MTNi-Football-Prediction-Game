<?php

namespace App\Listeners;

use App\Events\MatchResultRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Match;
use Illuminate\Support\Facades\Auth;

class CalculateUserPoints
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
     * @param  MatchResultRegistered  $event
     * @return void
     */
    public function handle(MatchResultRegistered $event)
    {

    }
}
