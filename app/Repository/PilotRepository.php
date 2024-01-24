<?php

namespace App\Repository;

use App\Models\Pilot;

/**
 *
 */
class PilotRepository
{
    /**
     * @param $data
     * @return mixed
     */
    public function create($data): mixed
    {
        return Pilot::updateOrCreate($data);
    }

    /**
     * @return mixed mixed'
     */
    public function getAll(): mixed
    {
        return Pilot::orderBy('code')->get();
    }
}
