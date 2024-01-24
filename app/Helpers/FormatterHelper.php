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

if (!function_exists('format_speed')) {
    function format_speed($speed)
    {
        return $speed . ' km/h';
    }
}
