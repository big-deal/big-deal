<?php

return [
    \App\Models\Beeline::class => [
        \App\Observers\BeelineObserver::class,
    ],
    \App\Models\Amo::class => [
        \App\Observers\AmoSettingableObserver::class,
    ],
    \App\Models\AmoManager::class => [
        \App\Observers\AmoSettingableObserver::class,
    ],
];
