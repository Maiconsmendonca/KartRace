<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
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
        'codigo', 'nomePiloto'
    ];

    /**
     * @return HasMany
     */
    public function raceResults(): HasMany
    {
        return $this->hasMany(RaceResult::class);
    }
}
