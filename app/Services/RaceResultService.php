<?php

namespace App\Services;

use App\Models\Lap;
use App\Models\Pilot;
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
        return $this->prepareRaceResultsForDisplay();
    }

    /**
     * @return array|null
     */
    public function prepareRaceResultsForDisplay(): ?array
    {
        try {
            $raceResults = $this->raceResultRepository->getAll();

            $preparedResults = [];

            foreach ($raceResults['resultados'] as $result) {
                if ($result) {
                    $preparedResult = [
                        'posicaoChegada' => $result['posicaoChegada'],
                        'codigoPiloto' => $result['codigo'],
                        'nomePiloto' => $result['nomePiloto'],
                        'voltasCompletadas' => $result['voltasCompletadas'],
                        'tempoTotal' => $result['tempoTotal'],
                        'voltas' => $this->prepareVoltaData($result),
                    ];

                    $preparedResults[] = $preparedResult;
                }
            }

            return $preparedResults;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return array
     */
    protected function prepareVoltaData($result): array
    {

        // Obtém o código do piloto do resultado
        $pilotCode = $result['codigo'];

        $raceResult = RaceResult::whereHas('pilot', function ($query) use ($pilotCode) {
            $query->where('code', $pilotCode);
        })->first();

        if ($raceResult) {
            $laps = $raceResult->lap;

            $preparedLaps = [];

            foreach ($laps as $lap) {
                $preparedLaps[] = [
                    'numero' => $lap->number,
                    'horaVolta' => $lap->lapHour,
                    'tempoVolta' => $lap->lapTime,
                    'velocidadeMedia' => $lap->averageSpeed,
                ];
            }
            return $preparedLaps;
        }
    }
}
