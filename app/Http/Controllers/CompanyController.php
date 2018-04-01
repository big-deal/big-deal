<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Auth::user()
            ->companies()
            ->paginate(null, ['companies.id', 'companies.title', 'companies.updated_at']);

        return view('companies.browse', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        return static::viewCreateOrEdit($company);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        return static::insertOrUpdate($request, $company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return static::viewCreateOrEdit($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        return static::insertOrUpdate($request, $company);
    }

    /**
     * Create or edit view.
     *
     * @param \App\Models\Company $company
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
        } catch (\Exception $e) {
            session(['status', $e->getMessage()]);
        }

        return redirect(route('companies.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    protected function viewCreateOrEdit(Company $company)
    {
        return view('companies.edit-add', compact('company'));
    }

    /**
     * Insert or Update method.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    protected function insertOrUpdate(Request $request, Company $company)
    {
        $company_fill = $request->only((new Company)->getFillable());

        if ($company->id) {
            $company->update($company_fill);
        } else {
            $company = Auth::user()
                ->companies()
                ->create($company_fill);
        }

        return static::viewCreateOrEdit($company);
    }
}
