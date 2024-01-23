<?php

namespace App\Http\Controllers;

use App\Services\RaceResultService;
use Illuminate\Http\JsonResponse;

/**
 * Class responsible for calling the race methods
 */
class RaceResultController extends Controller
{
    /**
     * @var RaceResultService
     */
    protected RaceResultService $raceResultService;

    /**
     * @param RaceResultService $raceResultService
     */
    public function __construct(RaceResultService $raceResultService)
    {
        $this->raceResultService = $raceResultService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $raceResults = $this->raceResultService->getRaceResults();

            $formattedResults = $this->formatResults($raceResults);

            return response()->json($formattedResults, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function formatResults($raceResults): array
    {
        return [
            'resultados' => $raceResults,
        ];
    }
}
