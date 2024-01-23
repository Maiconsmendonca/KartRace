<?php

namespace App\Repository;

use App\Models\RaceResult;

/**
 * Class responsible for querying the database
 */
class RaceResultRepository
{
    /**
     * @param $data
     * @return mixed
     */
    public function create($data): mixed
    {
        return RaceResult::updateOrCreate($data);
    }

    /**
     * @return mixed
     */
    public function getAll(): mixed
    {
        return RaceResult::orderBy('posicaoChegada')->get();
    }
}
