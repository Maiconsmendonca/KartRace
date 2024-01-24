<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;

/**
 * Class responsible for calling race statistics
 */
class StatisticsController extends Controller
{
    /**
     * @var StatisticsService
     */
    protected StatisticsService $statisticsService;

    /**
     * @param StatisticsService $statisticsService
     */
    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * @return JsonResponse
     */
    public function allRaceInformation(): JsonResponse
    {
        $allRaceInformation = $this->statisticsService->getAllRaceInformation();

        return response()->json($allRaceInformation);
    }

    /**
     * @param $raceResults
     * @return array
     */
    protected function formatResults($raceResults): array
    {
        return [
            'resultados' => $raceResults,
        ];
    }

    /**
     * @return JsonResponse
     */
    public function averageSpeedForEachPilot(): JsonResponse
    {
        try {
            $raceResults = $this->statisticsService->calculateAverageSpeedForEachPilot();

            $formattedResults = $this->formatResults($raceResults);

            return response()->json($formattedResults, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function bestLapForEachPilot(): JsonResponse
    {
        try {
            $raceResults = $this->statisticsService->calculateAverageSpeedForEachPilot();

            $formattedResults = $this->formatResults($raceResults);

            return response()->json($formattedResults, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function bestLapOfTheRace(): JsonResponse
    {
        try {
            $raceResults = $this->statisticsService->getBestLapOfTheRace();

            $formattedResults = $this->formatResults($raceResults);

            return response()->json($formattedResults, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

}
