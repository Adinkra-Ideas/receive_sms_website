<?php
// Dont directly access this file
//die;

function time_ago($datetime) {
    // Set Lagos timezone for all date/time operations
    $lagos_tz = new DateTimeZone('Africa/Lagos');

    // Convert input to DateTime object
    try {
        $date = new DateTime($datetime, $lagos_tz);
    } catch (Exception $e) {
        return 'invalid date';
    }

    // Get current time in Lagos timezone
    $now = new DateTime('now', $lagos_tz);

    // Calculate absolute difference in seconds
    $elapsed = $now->getTimestamp() - $date->getTimestamp();
    $absolute = abs($elapsed);

    if ($absolute < 1) {
        return 'just now';
    }

    // Get the relative interval components
    $diff = $now->diff($date);

    $intervals = [
        ['year' => $diff->y],
        ['month' => $diff->m],
        ['week' => floor($diff->d / 7)],
        ['day' => $diff->d % 7],
        ['hour' => $diff->h],
        ['minute' => $diff->i],
        ['second' => $diff->s]
    ];

    foreach ($intervals as $interval) {
        foreach ($interval as $unit => $value) {
            if ($value > 0) {
                $direction = $elapsed > 0 ? 'ago' : 'from now';
                return "$value $unit" . ($value > 1 ? 's' : '') . " $direction";
            }
        }
    }

    return 'just now';
}

?>
