<?php

use App\Models\Lap;

if (!function_exists('format_date')) {
    /**
     * @param $date
     * @param $format
     * @return string
     */
    function format_date($date, $format = 'd/m/Y'): string
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('format_time')) {
    /**
     * @param $time
     * @return string
     */
    function format_time($time): string
    {
        $minutes = floor($time / 60);
        $seconds = $time % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}

if (!function_exists('convert_time_to_milessimos')) {
    /**
     * @param $time
     * @return float|int|string
     */
    function convert_time_to_milessimos($time): float|int|string
    {
        $replace = str_replace(':', '.', $time);

        list($minutes, $seconds, $thousandths) = explode('.', $replace);

        $time_thousandths = ($minutes * 60 * 1000) + ($seconds * 1000) + $thousandths;

        return $time_thousandths;
    }
}

if (!function_exists('convert_milessimos_to_mm_ss_nnn')) {
    /**
     * @param $milessimos
     * @return string
     */
    function convert_milessimos_to_mm_ss_nnn($milessimos)
    {
        $minutes = floor($milessimos / 60000);
        $seconds = floor(($milessimos % 60000) / 1000);
        $milliseconds = $milessimos % 1000;

        $formattedTime = sprintf('%02d:%02d.%03d', $minutes, $seconds, $milliseconds);

        return $formattedTime;
    }
}

if (!function_exists('calculateAverageSpeed')) {
    /**
     * @param $lapSpeeds
     * @return int
     */
    function calculateAverageSpeed($lapSpeeds)
    {
        $laps = Lap::whereHas('raceResult', function ($query) use ($lapSpeeds) {
            $query->where('pilot_id', $lapSpeeds);
        })->get();

        if ($laps->isEmpty()) {
            return 0;
        }

        $averageSpeed = $laps->avg('averageSpeed');

        return $averageSpeed;
    }
}

if (!function_exists('calculateAverageSpeed')) {
    /**
     * @param $formattedTime
     * @return float|int|mixed
     */
    function convertTimeToSeconds($formattedTime)
    {
        list($minutes, $seconds, $milliseconds) = sscanf($formattedTime, "%d:%d.%d");

        $totalSeconds = ($minutes * 60) + $seconds + ($milliseconds / 1000);

        return $totalSeconds;
    }
}

if (!function_exists('format_speed')) {
    /**
     * @param $speed
     * @return string
     */
    function format_speed($speed)
    {
        return $speed . ' km/h';
    }
}
