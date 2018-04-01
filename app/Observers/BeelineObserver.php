<?php

namespace App\Observers;

use App\Models\Beeline;
use App\Jobs\Beeline\Subscribe;

class BeelineObserver
{
    /**
     * @param \App\Models\Beeline $beeline
     */
    public function saved(Beeline $beeline)
    {
        Subscribe::dispatch($beeline, true);
    }
}
