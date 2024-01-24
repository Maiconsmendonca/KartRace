<?php

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd/m/Y'): string
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('format_time')) {
    function format_time($time): string
    {
        $minutes = floor($time / 60);
        $seconds = $time % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}

if (!function_exists('convert_time_to_milessimos')) {
    function convert_time_to_milessimos($time): float|int|string
    {
        $replace = str_replace(':', '.', $time);

        list($minutes, $seconds, $thousandths) = explode('.', $replace);


        $time_thousandths = ($minutes * 60 * 1000) + ($seconds * 1000) + $thousandths;

        return $time_thousandths;
    }
}

function convert_milessimos_to_mm_ss_nnn($milessimos)
{
    $minutes = floor($milessimos / 60000);
    $seconds = floor(($milessimos % 60000) / 1000);
    $milliseconds = $milessimos % 1000;

    $formattedTime = sprintf('%02d:%02d.%03d', $minutes, $seconds, $milliseconds);

    return $formattedTime;
}

if (!function_exists('format_speed')) {
    function format_speed($speed)
    {
        return $speed . ' km/h';
    }
}
