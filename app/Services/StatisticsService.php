<?php

namespace App\Services;


use App\Models\Lap;
use App\Models\Pilot;
use App\Models\RaceResult;
use App\Repository\LapRepository;
use App\Repository\PilotRepository;
use App\Repository\RaceResultRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\ExecutionStatus;

/**
 * Class responsible for race statistics services
 */
class StatisticsService
{
    /**
     * @var PilotRepository
     */
    protected PilotRepository $pilotRepository;
    /**
     * @var RaceResultRepository
     */
    protected RaceResultRepository $raceResultRepository;
    /**
     * @var LapRepository
     */
    protected LapRepository $lapRepository;

    /**
     * @param PilotRepository $pilotRepository
     * @param RaceResultRepository $raceResultRepository
     * @param LapRepository $lapRepository
     */
    public function __construct(
        PilotRepository      $pilotRepository,
        RaceResultRepository $raceResultRepository,
        LapRepository        $lapRepository
    )
    {
        $this->pilotRepository = $pilotRepository;

        $this->raceResultRepository = $raceResultRepository;

        $this->lapRepository = $lapRepository;

    }

    /**
     * @return JsonResponse
     */
    public function getBestLapOfTheRace(): JsonResponse
    {
        $bestLap = Lap::orderBy('lapHour')->first();

        if ($bestLap) {
            $bestLapData = [
                'pilot_name' => $bestLap->raceResult->pilot->pilotName,
                'lap_number' => $bestLap->number,
                'lap_hour' => $bestLap->lapHour,
                'best_time' => $bestLap->lapTime
            ];
        } else {
            $bestLapData = null;
        }
        return response()->json($bestLapData);
    }

    /**
     * @return JsonResponse
     */
    public function getBestLapForEachPilot(): JsonResponse
    {
        $pilots = Pilot::all();

        $pilotsData = [];

        foreach ($pilots as $pilot) {
            $bestLap = Lap::whereHas('raceResult', function ($query) use ($pilot) {
                $query->where('pilot_id', $pilot->id);
            })->orderBy('lapHour')->first();

            if ($bestLap) {
                $bestLapNumber = $bestLap->number;
            } else {
                $bestLapNumber = null;
            }

            $pilotsData[] = [
                'nome_piloto' => $pilot->pilotName,
                'melhor_volta' => $bestLapNumber,
            ];
        }

        return response()->json($pilotsData);
    }

    /**
     * @return JsonResponse
     */
    public function calculateAverageSpeedForEachPilot(): JsonResponse
    {
        $pilots = Pilot::all();

        $pilotsData = [];

        foreach ($pilots as $pilot) {
            $bestLap = Lap::whereHas('raceResult', function ($query) use ($pilot) {
                $query->where('pilot_id', $pilot->id);
            })->orderBy('lapHour')->first();

            if ($bestLap) {
                $bestTime = $bestLap->lapHour;
            } else {
                $bestTime = null;
            }

            $pilotsData[] = [
                'nome_piloto' => $pilot->pilotName,
                'melhor_tempo' => $bestTime,
            ];
        }

        return response()->json($pilotsData);
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
}
