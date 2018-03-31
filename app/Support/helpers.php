<?php

declare(strict_types=1);

if (! function_exists('have_fun')) {
    function have_fun($normal = 1, $april_fools_day = 50)
    {
        $now = \Carbon\Carbon::now();

        return rand(1, 100) > (100 - ($now->month === 4 && $now->day === 1 ? $april_fools_day : $normal));
    }
}
