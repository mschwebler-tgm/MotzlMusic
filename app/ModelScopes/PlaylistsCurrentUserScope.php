<?php

namespace App\ModelScopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PlaylistsCurrentUserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('user_id', '=', apiUser()->id);
    }
}
