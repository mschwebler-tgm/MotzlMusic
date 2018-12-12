<?php

namespace App\Components\Spotify\Models;

class AudioFeatures extends BaseModel
{
    /** @var string */
    public $id;
    /** @var float */
    public $energy;
    /** @var float */
    public $valence;
    /** @var float */
    public $danceability;
    /** @var float */
    public $speechiness;
    /** @var float */
    public $acousticness;
    /** @var float */
    public $instrumentalness;
    /** @var float */
    public $liveness;
    /** @var float */
    public $loudness;
    /** @var int */
    public $key;
    /** @var int */
    public $mode;
    /** @var float */
    public $tempo;
    /** @var string */
    public $type;
    /** @var string */
    public $uri;
    /** @var string */
    public $trackHref;
    /** @var string */
    public $analysisUrl;
    /** @var int */
    public $duration;
    /** @var int */
    public $timeSignature;

    public function __construct($apiResponseAudioFeatures)
    {
        parent::__construct($apiResponseAudioFeatures);

        $this->setAttributesFromResponse([
            'id',
            'energy',
            'valence',
            'danceability',
            'speechiness',
            'acousticness',
            'instrumentalness',
            'liveness',
            'loudness',
            'key',
            'mode',
            'tempo',
            'type',
            'uri',
            'trackHref' => 'track_href',
            'analysisUrl' => 'analysis_url',
            'duration' => 'duration_ms',
            'timeSignature' => 'time_signature',
        ]);
    }
}
