<?php

namespace App\Repository;

use App\Models\Lap;

class LapRepository
{
    public function getLap()
    {
        return Lap::with('race_results')->get();
    }



}
