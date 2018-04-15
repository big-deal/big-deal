<?php

namespace App\Traits;

use App\Models\AmoSetting;

trait AmoSettingable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function settings()
    {
        return $this->morphOne(AmoSetting::class, 'settingable');
    }
}
