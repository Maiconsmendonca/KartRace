<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use Illuminate\Http\JsonResponse;

class PilotController extends Controller
{
    /**
     * @var Pilot
     */
    protected Pilot $pilot;

    /**
     * @param Pilot $pilot
     */
    public function __construct(Pilot $pilot)
    {
        $this->pilot = $pilot;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $pilotsResults = $this->pilot->all();

            $formattedResults = $this->formatResults($pilotsResults);

            return response()->json($formattedResults, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function formatResults($pilotsResults): array
    {
        return [
            'resultados' => $pilotsResults,
        ];
    }
}
