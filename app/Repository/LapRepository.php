<?php

namespace App\Repository;

use App\Models\Lap;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class LapRepository
{
    /**
     * @return Builder[]|Collection
     */
    public function getLap()
    {
        return Lap::with('race_results')->get();
    }
}
