<?php

namespace App\Http\Middleware;

use App\ModelScopes\ScopeManager;
use Closure;

class PrivateLibrary
{
    public function handle($request, Closure $next)
    {
        ScopeManager::registerCurrentUserScopes();
        return $next($request);
    }
}
