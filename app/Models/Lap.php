<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class responsible for race results
 */
class Lap extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'numero', 'horavolta', 'tempoVolta', 'velocidadeMedia', 'piloto_id'
    ];

    /**
     * @return BelongsTo
     */
    public function raceResult(): BelongsTo
    {
        return $this->belongsTo(RaceResult::class);
    }
}
