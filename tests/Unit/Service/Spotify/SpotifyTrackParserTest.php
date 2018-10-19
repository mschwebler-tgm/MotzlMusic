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
        $spotifyResult->type = 'test';
        $trackParser = new SpotifyTrackParser($spotifyResult);

        $trackParserReturnValue = $trackParser->get('name', 'type');

        $this->assertEquals([
            'name' => 'test name',
            'type' => 'test'
        ], $trackParserReturnValue);
    }

    public function testGetMethodReturnsNullForNonExistingValues()
    {
        $spotifyResult = new \stdClass();
        $spotifyResult->name = 'test name';
        $trackParser = new SpotifyTrackParser($spotifyResult);

        $trackParserReturnValue = $trackParser->get('name', 'type');

        $this->assertEquals([
            'name' => 'test name',
            'type' => null
        ], $trackParserReturnValue);
    }

    public function testGetMethodReturnsNestedValuesByPointSeperation()
    {
        $spotifyResult = new \stdClass();
        $spotifyResult->name = 'test name';
        $nestedObj = new \stdClass();
        $nestedObj->name = 'i am nested';
        $spotifyResult->nested = $nestedObj;
        $trackParser = new SpotifyTrackParser($spotifyResult);

        $trackParserReturnValue = $trackParser->get('name', 'nested2.name');

        $this->assertEquals([
            'name' => 'test name',
            'nested' => [
                'name' => 'i am nested'
            ]
        ], $trackParserReturnValue);
    }
}
