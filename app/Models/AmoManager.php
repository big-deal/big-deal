<?php

namespace App\Models;

use App\Traits\AmoSettingable;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\AmoSettingable as AmoSettingableContract;

class AmoManager extends Model implements AmoSettingableContract
{
    use AmoSettingable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function amo()
    {
        return $this->belongsTo(Amo::class);
    }
}
