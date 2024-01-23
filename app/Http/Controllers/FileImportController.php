<?php

namespace App\Http\Controllers;

use App\Models\FileImport;
use App\Models\Pilot;
use App\Services\FileImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * Class responsible for importing and processing the .log file
 */
class FileImportController extends Controller
{
    /**
     * @var FileImportService
     */
    protected FileImportService $fileImportService;

    /**
     * @param FileImportService $fileImportService
     */
    public function __construct(FileImportService $fileImportService)
    {
        $this->fileImportService = $fileImportService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function processLog(Request $request): JsonResponse
    {
        try {
            if ($request->hasFile('file')) {
                $logFile = $request->file('file');

                $logContent = file_get_contents($logFile->path());

                $lines = explode("\n", $logContent);
                array_shift($lines);

                try {
                    foreach ($lines as $line) {
                        $this->fileImportService->processLog($line);
                    }

                    return response()->json(['message' => 'Log processed successfully']);
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            } else {
                return response()->json(['error' => 'Log file not provided'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
