<?php

namespace App\Repository;

use App\Models\Lap;
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
     * @return mixed'id'
     */
    public function getAll(): mixed
    {
        $results = RaceResult::with('pilot')
            ->orderBy('finishingPosition')
            ->get();

        $formattedResults = $results->map(function ($result) {
            return [
                'id' => $result->id,
                'codigo' => $result->pilot->code,
                'nomePiloto' => $result->pilot->pilotName,
                'voltasCompletadas' => $result->lapsCompleted,
                'tempoTotal' => $result->totalTime,
                'posicaoChegada' => $result->finishingPosition,
                'created_at' => $result->created_at,
                'updated_at' => $result->updated_at,
            ];
        });

        return ['resultados' => $formattedResults];
    }
}
