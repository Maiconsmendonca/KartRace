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
}
