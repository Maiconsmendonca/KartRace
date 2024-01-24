<?php

namespace App\Repository;

use App\Models\Pilot;

class PilotRepository
{
    public function create($data): mixed
    {
        return Pilot::updateOrCreate($data);
    }

    /**
     * @return mixed'id'
     */
    public function getAll(): mixed
    {
        return Pilot::orderBy('code')->get();
    }
}
