<?php

/**
 * @return \App\User|null
 */
function apiUser() {
    return auth()->guard('api')->user();
}