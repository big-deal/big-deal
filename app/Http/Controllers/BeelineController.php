<?php

namespace App\Http\Controllers;

use App\Models\Beeline;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\Beeline\Store;

class BeelineController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Company $company
     * @param  \App\Models\Beeline $beeline
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company, Beeline $beeline)
    {
        return static::viewCreateOrEdit($company, $beeline);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Beeline\Store $request
     * @param  \App\Models\Company $company
     * @param  \App\Models\Beeline $beeline
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, Company $company, Beeline $beeline)
    {
        return static::insertOrUpdate($request, $company, $beeline);
    }

    /**
     * Create or edit view.
     *
     * @param  \App\Models\Company $company
     * @param \App\Models\Beeline $beeline
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Company $company, Beeline $beeline)
    {
        try {
            $beeline->delete();
        } catch (\Exception $e) {
            session(['status', $e->getMessage()]);
        }

        return redirect(route('companies.edit', [$company]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company $company
     * @param  \App\Models\Beeline $beeline
     *
     * @return \Illuminate\Http\Response
     */
    protected function viewCreateOrEdit(Company $company, Beeline $beeline)
    {
        return view('beelines.edit-add', compact('company', 'beeline'));
    }

    /**
     * Insert or Update method.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     * @param  \App\Models\Beeline $beeline
     *
     * @return \Illuminate\Http\Response
     */
    protected function insertOrUpdate(Request $request, Company $company, Beeline $beeline)
    {
        $beeline_fill = $request->only((new Beeline)->getFillable());

        if ($beeline->id) {
            $beeline->update($beeline_fill);
        } else {
            $beeline = $company->beelines()
                ->create($beeline_fill);
        }

        return redirect(route('companies.edit', $company));
    }
}
