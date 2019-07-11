<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface HasTracks
{
    /** @return BelongsToMany */
    public function tracks();
}
