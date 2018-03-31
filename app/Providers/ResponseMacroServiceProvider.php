<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Response::macro('success', function ($data) {
            return response()
                ->json([
                    'errors' => false,
                    'data' => $data,
                ])
                ->withCallback(request()->input('callback'));
        });

        Response::macro('error', function ($message, $status = 400) {
            return response()
                ->json([
                    'errors' => true,
                    'message' => $message,
                ], $status)
                ->withCallback(request()->input('callback'));
        });
    }
}
