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

        $timeReturn = $data['lapHour'];
        $code = $data['code'];
        $pilotName = $data['pilotName'];
        $lap = $data['lap'];
        $timeLap = $data['lapTime'];
        $averagespeed = $data['averageSpeed'];

        $pilot = Pilot::firstOrCreate(['code' => $data['code']], ['pilotName' => $data['pilotName']]);

        $raceResult = RaceResult::firstOrCreate(['pilot_id' => $pilot->id], [
            'pilot_id' => $pilot->id,
            'lapsCompleted' => $lap,
            'totalTime' => $this->timeForSeconds($data['lapTime']),
            'finishingPosition' => 0,
        ]);

        $lapData = [
            'number' => $lap,
            'lapHour' => $timeReturn,
            'lapTime' => $this->formatTime($timeLap),
            'averageSpeed' => $this->formatSpeed($averagespeed),
            'race_results_id' => $raceResult->id,
        ];

        Lap::updateOrCreate(['number' => $lap, 'race_results_id' => $raceResult->id], $lapData);

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
                    'lapHour' => $lineData[0],
                    'code' => $lineData[1],
                    'pilotName' => $lineData[2],
                    'lap' => $lineData[3],
                    'lapTime' => $lineData[4],
                    'averageSpeed' => $lineData[5],
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
