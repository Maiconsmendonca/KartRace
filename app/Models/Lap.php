<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class responsible for race results
 */
class Lap extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'number', 'lapHour', 'lapTime', 'averageSpeed', 'race_results_id'
    ];

    /**
     * @return BelongsTo
     */
    public function raceResult(): BelongsTo
    {
        return $this->belongsTo(RaceResult::class, 'race_results_id');
    }
}
