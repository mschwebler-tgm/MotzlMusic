<?php

namespace App\Components\Spotify\Import\Importers;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSpotifyImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var SpotifyImporter $importer */
    private $importer;
    private $importOptions;

    public function __construct(SpotifyImporter $importer, $options)
    {
        $this->importer = $importer;
        $this->importOptions = $options;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->importer->import($this->importOptions);
        // TODO implement
    }
}
