<?php

namespace App\Components\Spotify\Import\Importers;

interface SpotifyImporter
{
    public function import($options);
}
