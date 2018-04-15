<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('success', function ($response, $status = 200) {
            return response()
                ->json([
                    'response' => $response,
                ], $status)
                ->withCallback(request()->input('callback'));
        });

        Response::macro('error', function ($error, $status = 400) {
            return response()
                ->json([
                    'error' => $error,
                ], $status)
                ->withCallback(request()->input('callback'));
        });
    }
}
