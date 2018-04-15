<?php

namespace App\Http\Controllers\Api;

use AmoCRM\Client;
use AmoCRM\Models\Account as AmoCRMAccount;
use App\Http\Controllers\Controller;
use App\Models\Amo;
use Illuminate\Http\Request;

class AmoController extends Controller
{
    /**
     * Api method for get statuses and custom fields.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Amo $amo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFields(Request $request, Amo $amo)
    {
        $connection = $amo->connection;

        if (!is_null($connection)) {
            $response = static::getStatusesAndCustomFields($connection->account);

            return response()->success($response);
        } else {
            return response()->error([
                'code' => 110,
                'message' => 'Неправильный логин или пароль',
            ], 401);
        }
    }

    /**
     * Api method for check auth and get statuses and custom fields.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(Request $request)
    {
        $request->validate([
            'domain' => 'required',
            'login' => 'required',
            'hash' => 'required',
        ]);

        try {
            $amo = new Client($request->domain, $request->login, $request->hash);

            $response = static::getStatusesAndCustomFields($amo->account);

            return response()->success($response);
        } catch (\Exception $e) {
            return response()->error([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    protected static function getStatusesAndCustomFields(AmoCRMAccount $account): array
    {
        $account = $account->apiCurrent();

        $response = [
            'statuses' => collect($account['pipelines'])
                ->sortBy('sort')
                ->map(function ($item) {
                    $pipeline = collect($item)->only('id', 'name');

                    $pipeline['statuses'] = collect($item['statuses'])
                        ->sortBy('sort')
                        ->map(function ($item) {
                            return collect($item)->only('id', 'name');
                        })
                        ->toArray();

                    return $pipeline;
                })
                ->toArray(),
            'fields' => collect($account['custom_fields']['leads'])
                ->sortBy('sort')
                ->map(function ($item) {
                    return collect($item)->only('id', 'name', 'enums');
                })
                ->toArray(),
        ];

        return $response;
    }
}
