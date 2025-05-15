<?php

namespace App\Models;

use App\Enums\ServiceName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ErpSync extends Model
{
    protected $fillable = [
        'service',
        'status',
        'response',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'service' => ServiceName::class,
        'response' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function syncable(): MorphTo
    {
        return $this->morphTo();
    }
}
