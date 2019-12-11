<?php

namespace App\ModelScopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TracksCurrentUserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereHas('owningUsers', function ($query) {
            $user = apiUser();
            if ($user) {  // for ide-helper
                /** @var $query Builder */
                $query->where('id', apiUser()->id);
            }
        });
    }
}
