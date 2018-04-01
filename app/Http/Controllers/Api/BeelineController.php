<?php

namespace App\Http\Controllers\Api;

use App\Models\Beeline;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeelineController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beeline $beeline
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request, Beeline $beeline)
    {
        return response()->success('OK');
    }
}
