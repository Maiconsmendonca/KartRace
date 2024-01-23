<?php

namespace App\Services;

use App\Models\Pilot;
use App\Models\RaceResult;
use App\Models\Lap;
use App\Repository\RaceResultRepository;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class FileImportService
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
     * @throws Exception
     */
    public function processLog($logFile): void
    {
        try {
            $this->processLogPilots($logFile);

            //$this->processResultsRace();

            //$this->insertInformationTurns();
        } catch (Exception $e) {
            throw $e;
        }

    }

    /**
     * @param $logFile
     * @return void
     */
    public function processLogPilots($logFile): void
    {
        $data = $this->extractData($logFile);

        $timeReturn = $data['horaVolta'];
        $code = $data['codigo'];
        $pilotName = $data['nomePiloto'];
        $lap = $data['volta'];
        $timeLap = $data['tempoVolta'];
        $averagespeed = $data['velocidadeVolta'];

        $pilot = Pilot::firstOrCreate(['codigo' => $data['codigo']], ['nomePiloto' => $data['nomePiloto']]);

        $lapData = [
            'numero' => $lap,
            'horavolta' => $timeReturn,
            'tempoVolta' => $this->formatTime($timeLap),
            'velocidadeMedia' => $this->formatSpeed($averagespeed),
            'piloto_id' => $pilot->id,
        ];

        Lap::updateOrCreate(['numero' => $lap, 'piloto_id' => $pilot->id], $lapData);

        $resultRaceDate = [
            'codigo' => $code,
            'nomePiloto' => $pilotName,
            'voltasCompletadas' => $lap,
            'tempoTotal' => $this->timeForSeconds($data['tempoVolta']),
            'posicaoChegada' => $this->calculateArrivalPosition($pilot->id, $lap),
            'piloto_id' => $pilot->id,
        ];

        $raceResult = RaceResult::where('codigo', $code)->first();

        if ($raceResult) {
            $raceResult->update($resultRaceDate);
        }
        RaceResult::create($resultRaceDate);
    }

    /**
     * @param $pilotId
     * @param $lapsCompleted
     * @return int
     */
    public function calculateArrivalPosition($pilotId, $lapsCompleted): int
    {
        return 0;
    }

    /**
     * @return void
     */
    public function insertInformationTurns()
    {
    }

    /**
     * @param $data
     * @return array|null
     */
    public function extractData($data): ?array
    {
        try {
            $line = str_replace('– ', '', $data);
            $lineData = explode(' ', $line);

            if (count($lineData) >= 6) {
                return [
                    'horaVolta' => $lineData[0],
                    'codigo' => $lineData[1],
                    'nomePiloto' => $lineData[2],
                    'volta' => $lineData[3],
                    'tempoVolta' => $lineData[4],
                    'velocidadeVolta' => $lineData[5],
                ];
            }

            return null;
        } catch (Exception $e) {
            Log::error('Error extracting data: ' . $e->getMessage());
            return null; // Failure
        }
    }

    /**
     * @return void
     */
    protected function calculateStatistics(): void
    {
        $pilots = Pilot::all();

        foreach ($pilots as $pilot) {
            $raceResults = $pilot->raceResults;

            if ($raceResults->count() > 0) {
                $totalSpeed = $raceResults->sum(function ($result) {
                    return $result->voltas->avg('velocidadeMedia');
                });

                $averageSpeed = $totalSpeed / $raceResults->count();

                Log::info("Average speed for {$pilot->nomePiloto}: {$averageSpeed} km/h");
            }
        }
    }

    /**
     * @param $time
     * @return float|int
     */
    public function timeForSeconds($time): float|int
    {
        $timeParties = explode(':', $time);

        $minutes = isset($timeParties[0]) ? (int)$timeParties[0] : 0;

        $secondParties = explode('.', $timeParties[1]);

        $seconds = isset($secondParties[0]) ? (int)$secondParties[0] : 0;
        $milliseconds = isset($secondParties[1]) ? (int)$secondParties[1] : 0;

        return ($minutes * 60 + $seconds) + ($milliseconds / 1000);
    }

    /**
     * @param $time
     * @return string
     */
    public function formatTime($time): string
    {
        $timeParties = explode(':', $time);

        return sprintf('%02d:%02d:%06.3f', 0, $timeParties[0], $timeParties[1]);
    }

    /**
     * @param $speed
     * @return array|string|string[]
     */
    public function formatSpeed($speed): array|string
    {
        return str_replace(',', '.', $speed);
    }

}
