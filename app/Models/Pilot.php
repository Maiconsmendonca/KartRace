<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Class responsible for pilot results
 */
class Pilot extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'code', 'pilotName'
    ];

    /**
     * @return HasMany
     */
    public function raceResults(): HasMany
    {
        return $this->hasMany(RaceResult::class, 'pilot_id');
    }

    /**
     * @return HasMany
     */
    public function lap(): HasMany
    {
        return $this->hasMany(Lap::class);
    }
}
