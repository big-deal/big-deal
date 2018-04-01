<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beeline extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token',

        'subscribe_id',
        'subscribe_extension',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
