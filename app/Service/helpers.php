<?php

/**
 * @return \App\User|null
 */
function apiUser() {
    return auth()->guard('api')->user();
}

function formatDuration($milliseconds) {
    $seconds = $milliseconds / 1000;
    $minutes = floor($seconds / 60);
    $seconds = floor($seconds - $minutes * 60);
    $seconds = $seconds < 10 ? "0$seconds" : $seconds;

    return "$minutes:$seconds";
}
