<?php

declare(strict_types=1);

if (! function_exists('have_fun')) {
    function have_fun($normal = 1, $april_fools_day = 50)
    {
        $now = \Carbon\Carbon::now();

        return rand(1, 100) > (100 - ($now->month === 4 && $now->day === 1 ? $april_fools_day : $normal));
    }
}

if (! function_exists('debug_blacklist')) {
    function debug_blacklist($keys = [])
    {
        $superGlobalNames = [
            '_GET',
            '_POST',
            '_FILES',
            '_COOKIE',
            '_SESSION',
            '_SERVER',
            '_ENV',
        ];
        $result = [];

        foreach ($superGlobalNames as $superGlobalName) {
            foreach ($keys as $key) {
                $result[$superGlobalName][] = $key;
            }
        }

        return $result;
    }
}
