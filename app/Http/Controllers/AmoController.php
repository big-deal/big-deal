<?php

namespace App\Http\Controllers;

use Exception;
use AmoCRM\Client;
use App\Models\Amo;
use App\Models\Company;
use App\Models\AmoSetting;
use Illuminate\Http\Request;

class AmoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Company $company
     * @param  \App\Models\Amo $amo
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company, Amo $amo)
    {
        return static::viewCreateOrEdit($company, $amo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     * @param  \App\Models\Amo $amo
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company, Amo $amo)
    {
        return static::insertOrUpdate($request, $company, $amo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Company $company
     * @param  \App\Models\Amo $amo
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, Amo $amo)
    {
        return static::viewCreateOrEdit($company, $amo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     * @param  \App\Models\Amo $amo
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, Amo $amo)
    {
        return static::insertOrUpdate($request, $company, $amo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company $company
     * @param  \App\Models\Amo $amo
     *
     * @return \Illuminate\Http\Response
     */
    protected function viewCreateOrEdit(Company $company, Amo $amo)
    {
        return view('amo.edit-add', compact('company', 'amo'));
    }

    /**
     * Insert or Update method.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     * @param  \App\Models\Amo $amo
     *
     * @return \Illuminate\Http\Response
     */
    protected function insertOrUpdate(Request $request, Company $company, Amo $amo)
    {
        $amo_fill = $request->validate([
            'domain' => 'required',
            'login' => 'required',
            'hash' => 'required',
        ]);

        $amo_settings_fill = $request->validate([
            'settings.status' => 'required',
            'settings.minimum_duration' => 'numeric',
            'settings.recording' => 'nullable',
            'settings.roistat' => 'nullable',
            'settings.field' => 'nullable',
            'settings.value' => 'nullable',
        ])['settings'];

        try {
            $amoClient = new Client($request->domain, $request->login, $request->hash);
            $amo_fill['active'] = true;
        } catch (Exception $e) {
            $amo_fill['active'] = false;
        }

        if ($amo->id) {
            $amo->update($amo_fill);
        } else {
            $amo = $company->amo()
                ->create($amo_fill);
        }

        $amo->settings()
            ->updateOrCreate([], $amo_settings_fill);

        return redirect(route('companies.edit', $company));
    }

    /**
     * @param \App\Models\Company $company
     * @param \App\Models\Amo $amo
     *
     * @return \Illuminate\Http\Response
     */
    public function managersEdit(Company $company, Amo $amo)
    {
        $account = $amo->connection->account->apiCurrent();

        $managers = collect($account['users'])
            ->sortBy('id')
            ->map(function ($item) use ($amo) {
                /** @var \App\Models\AmoManager $manager */
                $manager = $amo->managers()
                    ->firstOrCreate(['id' => $item['id']]);
                $manager->name = $item['name'];
                $manager->last_name = $item['last_name'];

                return $manager;
            });

        return view('amo.managers.edit-add', compact('company', 'amo', 'managers'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @param \App\Models\Amo $amo
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function managersUpdate(Request $request, Company $company, Amo $amo)
    {
        $settings = collect($request->input('settings'));

        $amo->managers->each(function ($manager) use ($amo, $settings) {
            $manager_settings = collect($settings[$manager->id] ?? []);
            $amo_values = collect($amo->settings)->only((new AmoSetting)->getFillable());

            $manager->settings()
                ->updateOrCreate([], $manager_settings->diff($amo_values)
                    ->toArray());
        });

        return redirect(route('companies.edit', $company));
    }
}
