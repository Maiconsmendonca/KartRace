<?php

namespace App\Services;


use App\Models\Lap;
use App\Models\Pilot;
use App\Models\RaceResult;
use App\Repository\LapRepository;
use App\Repository\PilotRepository;
use App\Repository\RaceResultRepository;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\ExecutionStatus;

/**
 * Class responsible for race statistics services
 */
class StatisticsService
{

    protected PilotRepository $pilotRepository;
    protected RaceResultRepository $raceResultRepository;
    protected LapRepository $lapRepository;

    public function __construct(
        PilotRepository $pilotRepository,
        RaceResultRepository $raceResultRepository,
        LapRepository $lapRepository
    )
    {
        $this->pilotRepository = $pilotRepository;

        $this->raceResultRepository = $raceResultRepository;

        $this->lapRepository = $lapRepository;

    }

    public function getBestLapOfTheRace()
    {
        try {
            $bestLaps = [];

            // Obtém todos os pilotos
            $pilots = $this->pilotRepository->getAll();

            foreach ($pilots as $pilot) {
                // Obtém a melhor volta do piloto na corrida
                $bestLap = Lap::whereHas('raceResult', function ($query) use ($pilot) {
                    $query->where('piloto_id', $pilot->id);
                })
                    ->orderBy('tempoVolta', 'asc')
                    ->first();

                /*$bestLap = Lap::where('piloto_id', $pilot->id)
                    ->orderBy('tempoVolta', 'asc')
                    ->first();*/

                if ($bestLap) {
                    // Formata os dados e adiciona ao array
                    $bestLaps[] = [
                        'codigoPiloto' => $pilot->codigo,
                        'nomePiloto' => $pilot->nomePiloto,
                        'melhorTempo' => $bestLap->tempoVolta,
                        'melhorVolta' => $bestLap->numero,
                    ];
                }
            }
            return $bestLap;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return array|null
     */
    public function getBestLapForEachPilot()
    {
        try {

            $bestLaps = [];

            $pilots = $this->lapRepository->getLap();

            return $pilots;

            $bestLaps = [];

            foreach ($pilots as $result) {
                $fastestLap = $result->voltas->sortBy('tempoVolta')->first();
                $bestLaps[] = [
                    'piloto' => $result->piloto,
                    'bestLap' => $fastestLap,
                ];
            }

            dd($bestLaps);
            return $bestLaps;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return array|null
     */
    public function calculateAverageSpeedForEachPilot(): ?array
    {
        try {
            $pilots = RaceResult::with(['piloto', 'voltas'])->get();

            $averageSpeeds = [];

            foreach ($pilots as $result) {
                $averageSpeed = $result->voltas->avg('velocidadeMedia');
                $averageSpeeds[] = [
                    'piloto' => $result->piloto,
                    'averageSpeed' => $averageSpeed,
                ];
            }

            return $averageSpeeds;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return array|null
     */
    public function getTimeDifferenceFromWinnerForEachPilot(): ?array
    {
        try {
            $winner = RaceResult::orderBy('posicaoChegada')->first();
            $pilots = RaceResult::with(['piloto', 'voltas'])->get();

            $timeDifferences = [];

            foreach ($pilots as $result) {
                $timeDifference = $result->tempoTotal - $winner->tempoTotal;
                $timeDifferences[] = [
                    'piloto' => $result->piloto,
                    'timeDifference' => $timeDifference,
                ];
            }

            return $timeDifferences;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return array
     */
    public function getAllRaceInformation(): array
    {
        $bestLaps = $this->getBestLapForEachPilot();
        $bestLapOfTheRace = $this->getBestLapOfTheRace();
        $averageSpeeds = $this->calculateAverageSpeedForEachPilot();
        $timeDifferences = $this->getTimeDifferenceFromWinnerForEachPilot();

        return compact('bestLaps', 'bestLapOfTheRace', 'averageSpeeds', 'timeDifferences');
    }

    protected function calculateStatistics(): void
    {
        $pilots = Pilot::all();

        foreach ($pilots as $pilot) {
            $raceResults = $pilot->raceResults;

            if ($raceResults->count() > 0) {
                $totalSpeed = $raceResults->sum(function ($result) {
                    return $result->laps->avg('averageSpeed');
                });

                $averageSpeed = $totalSpeed / $raceResults->count();

                Log::info("Average speed for {$pilot->pilotName}: {$averageSpeed} km/h");
            }
        }
    }
}
