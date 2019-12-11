<?php

namespace App\ModelScopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ArtistsCurrentUserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereHas('tracks', function ($query) {
            /** @var $query Builder */
            $query->whereHas('owningUsers', function ($query) {
                /** @var $query Builder */
                $query->where('id', '=', apiUser()->id);
            });
        });
    }
}
