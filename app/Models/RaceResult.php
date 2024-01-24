<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class RaceResult extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'pilot_id', 'lapsCompleted', 'totalTime', 'finishingPosition'
    ];

    /**
     * @return BelongsTo
     */
    public function pilot(): BelongsTo
    {
        return $this->belongsTo(Pilot::class, 'pilot_id');
    }

    public function lap(): HasMany
    {
        return $this->hasMany(Lap::class, 'race_results_id');
    }
}
