<?php

namespace App\Observers;

use App\Jobs\Beeline\Subscribe;
use App\Models\Beeline;

class BeelineObserver
{
    /**
     * @param \App\Models\Beeline $beeline
     */
    public function saved(Beeline $beeline) {
        Subscribe::dispatch($beeline, true);
    }
}
