<?php

namespace App\Models;

use AmoCRM\Client;
use App\Traits\AmoSettingable;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\AmoSettingable as AmoSettingableContract;

class Amo extends Model implements AmoSettingableContract
{
    use AmoSettingable;

    /**
     * @var \AmoCRM\Client
     */
    protected $singletonAmoCRMConnection = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',

        'domain',
        'login',
        'hash',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function managers()
    {
        return $this->hasMany(AmoManager::class);
    }

    /**
     * @return \AmoCRM\Client
     */
    public function getConnectionAttribute()
    {
        if (is_null($this->singletonAmoCRMConnection)) {
            try {
                $this->singletonAmoCRMConnection = new Client($this->domain, $this->login, $this->hash);
            } catch (\Exception $e) {
                $this->update(['active' => false]);
            }
        }

        return $this->singletonAmoCRMConnection;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roistat_calls()
    {
        return $this->hasMany(RoistatCall::class);
    }
}
