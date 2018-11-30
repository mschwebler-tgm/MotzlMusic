<?php

namespace App\Jobs;

use App\Components\Spotify\Import\Importers\SpotifyImporter;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSpotifyImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var SpotifyImporter $importer */
    private $importer;
    private $idsToImport;

    public function __construct(SpotifyImporter $importer, $ids)
    {
        $this->importer = $importer;
        $this->idsToImport = $ids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->importer->import($this->idsToImport);
        // TODO implement
    }
}
