<?php

namespace App\Models;

use App\Services;
use App\Services\ReplaceDocumentServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class FileImport extends Model
{
    use HasFactory;

    /**
     * Method to import the log file and process the data
     *
     */
    public function getFileImport()
    {
        $relativePath = base_path("storage/logs/race.log");

        $logInfos = file($relativePath, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        return (new ReplaceDocument())->replaceFirstLineAndCaracters($logInfos);
    }
}
