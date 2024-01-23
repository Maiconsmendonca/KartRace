<?php

namespace App\Services;

use App\Models\RaceResult;
use App\Models\Lap;

/**
 * Class responsible for race statistics services
 */
class StatisticsService
{
    /**
     * @return null
     */
    public function getBestLapOfTheRace()
    {
        try {
            $bestLap = Lap::orderBy('tempoVolta')->first();

            return $bestLap;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return array|null
     */
    public function getBestLapForEachPilot(): ?array
    {
        try {
            $pilots = RaceResult::with(['piloto', 'voltas'])->get();

            $bestLaps = [];

            foreach ($pilots as $result) {
                $fastestLap = $result->voltas->sortBy('tempoVolta')->first();
                $bestLaps[] = [
                    'piloto' => $result->piloto,
                    'bestLap' => $fastestLap,
                ];
            }

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
}
