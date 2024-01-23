<?php

namespace App\Services;

use App\Models\RaceResult;
use App\Repository\RaceResultRepository;

/**
 * Class responsible for race results services
 */
class RaceResultService
{
    /**
     * @var RaceResultRepository
     */
    protected RaceResultRepository $raceResultRepository;

    /**
     * @param RaceResultRepository $raceResultRepository
     */
    public function __construct(RaceResultRepository $raceResultRepository)
    {
        $this->raceResultRepository = $raceResultRepository;
    }

    /**
     * @return mixed
     */
    public function getRaceResults(): mixed
    {
        return $this->raceResultRepository->getAll();
    }

    /**
     * @return array|null
     */
    public function prepareRaceResultsForDisplay(): ?array
    {
        try {
            $raceResults = RaceResult::with('piloto', 'voltas')->get();

            $preparedResults = [];

            foreach ($raceResults as $result) {
                $preparedResult = [
                    'posicaoChegada' => $result->posicaoChegada,
                    'codigoPiloto' => $result->piloto->codigo,
                    'nomePiloto' => $result->piloto->nomePiloto,
                    'voltasCompletadas' => $result->voltasCompletadas,
                    'tempoTotal' => $result->tempoTotal,
                    'voltas' => $this->prepareVoltaData($result->voltas),
                ];

                $preparedResults[] = $preparedResult;
            }

            return $preparedResults;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $laps
     * @return array
     */
    protected function prepareVoltaData($laps): array
    {
        $preparedVoltas = [];

        foreach ($laps as $lap) {
            $preparedVoltas[] = [
                'numero' => $lap->numero,
                'horaVolta' => $lap->horavolta,
                'tempoVolta' => $lap->tempoVolta,
                'velocidadeMedia' => $lap->velocidadeMedia,
            ];
        }

        return $preparedVoltas;
    }
}
