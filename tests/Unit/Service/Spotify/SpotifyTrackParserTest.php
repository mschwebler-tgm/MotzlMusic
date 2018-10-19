<?php

namespace Tests\Unit\Service\Spotify;

use App\Service\Spotify\SpotifyTrackParser;
use Tests\TestCase;

class SpotifyTrackParserTest extends TestCase
{

    public function testGetMethodReturnsMultipleValuesAsArray()
    {
        $spotifyResult = new \stdClass();
        $spotifyResult->name = 'test name';
        $trackParser = new SpotifyTrackParser($spotifyResult);

        $trackParserReturnValue = $trackParser->get('name');

        $this->assertEquals([
            'name' => 'test name'
        ], $trackParserReturnValue);
    }
}
