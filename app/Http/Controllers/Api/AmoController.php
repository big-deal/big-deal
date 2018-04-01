<?php

namespace App\Http\Controllers\Api;

use AmoCRM\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AmoController extends Controller
{
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

            $account = $amo->account->apiCurrent();

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

            return response()->success($response);
        } catch (\Exception $e) {
            return response()->error([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ], 401);
        }
    }
}
