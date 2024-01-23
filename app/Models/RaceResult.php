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
        'codigo', 'nomePiloto', 'voltasCompletadas', 'tempoTotal', 'posicaoChegada', 'piloto_id'
    ];

    /**
     * @return BelongsTo
     */
    public function pilot(): BelongsTo
    {
        return $this->belongsTo(Pilot::class);
    }

    /**
     * @return HasMany
     */
    public function lap(): HasMany
    {
        return $this->hasMany(Lap::class);
    }
}
