<?php

namespace App\Contracts;

interface AmoSettingable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function settings();
}
