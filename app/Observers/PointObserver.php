<?php

namespace App\Observers;

use App\Models\Point;
use App\Models\Points;

class PointObserver
{
    /**
     * Handle the Point "created" event.
     */
    public function created(Points $point): void
    {
        //
    }

    /**
     * Handle the Point "updated" event.
     */
    public function updated(Points $point): void
    {
        //
    }

    /**
     * Handle the Point "deleted" event.
     */
    public function deleted(Points $point): void
    {
        //
    }

    /**
     * Handle the Point "restored" event.
     */
    public function restored(Points $point): void
    {
        //
    }

    /**
     * Handle the Point "force deleted" event.
     */
    public function forceDeleted(Points $point): void
    {
        //
    }
}
