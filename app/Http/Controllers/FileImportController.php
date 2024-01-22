<?php

namespace App\Http\Controllers;

use App\Models\FileImport;
use Illuminate\Http\Request;


class FileImportController extends Controller
{
    public function importFile(): bool|array
    {
        return (new FileImport())->getFileImport();
    }
}
