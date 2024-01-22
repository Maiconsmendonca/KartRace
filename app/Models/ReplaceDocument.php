<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplaceDocument extends Model
{
    use HasFactory;

    public function replaceFirstLineAndCaracters($logInfos)
    {
        array_shift($logInfos);

        return str_replace('– ', '', $logInfos);
    }
}
