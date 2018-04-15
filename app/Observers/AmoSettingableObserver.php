<?php

namespace App\Observers;

use App\Contracts\AmoSettingable;

class AmoSettingableObserver
{
    /**
     * @param \App\Contracts\AmoSettingable $settingable
     */
    public function saved(AmoSettingable $settingable)
    {
        $settingable->settings()
            ->updateOrCreate([]);
    }
}
