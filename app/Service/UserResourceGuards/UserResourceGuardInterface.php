<?php

namespace App\Service\UserResourceGuards;

use Illuminate\Database\Eloquent\Model;

interface UserResourceGuardInterface
{
    public function get(Model $resource);
}
