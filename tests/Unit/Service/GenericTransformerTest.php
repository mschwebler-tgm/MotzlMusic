<?php

namespace Tests\Unit\Service\Spotify;

use App\Service\GenericTransformer;
use Tests\TestCase;

class GenericTransformerTest extends TestCase
{
    public function testGetMethodReturnsMultipleValuesAsArray()
    {
        $spotifyResult = new \stdClass();
        $spotifyResult->name = 'test name';
        $spotifyResult->type = 'test';
        $trackParser = new GenericTransformer($spotifyResult);

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
        $trackParser = new GenericTransformer($spotifyResult);

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
        $trackParser = new GenericTransformer($spotifyResult);

        $trackParserReturnValue = $trackParser->get('name', 'nested.name');

        $this->assertEquals([
            'name' => 'test name',
            'nested' => [
                'name' => 'i am nested'
            ]
        ], $trackParserReturnValue);
    }

    public function testGetMethodForcesGivenStructure()
    {
        $spotifyResult = new \stdClass();
        $spotifyResult->name = 'test name';
        $trackParser = new GenericTransformer($spotifyResult);

        $trackParserReturnValue = $trackParser->get('name', 'non.existing.object.name');

        $this->assertEquals([
            'name' => 'test name',
            'non' => [
                'existing' => [
                    'object' => [
                        'name' => null
                    ]
                ]
            ]
        ], $trackParserReturnValue);
    }

    public function testGetMethodWorksWithArrays()
    {
        $spotifyResult = new \stdClass();
        $spotifyResult->names = ['first', 'second'];
        $trackParser = new GenericTransformer($spotifyResult);

        $trackParserReturnValue = $trackParser->get('names.0');

        $this->assertEquals([
            'names' => [
                'first'
            ],
        ], $trackParserReturnValue);
    }

    public function testGetMethodWorksWithAsteriskWildcard()
    {
        $first = new \stdClass();
        $first->name = 'first name';
        $first->type = 'bruh';
        $second = new \stdClass();
        $second->name = 'second name';
        $second->type = 'bruh2';
        $spotifyResult = new \stdClass();
        $spotifyResult->names = [
            'first' => $first,
            'second' => $second
        ];
        $trackParser = new GenericTransformer($spotifyResult);

        $trackParserReturnValue = $trackParser->get('names.*.name', 'names.*.type');

        $this->assertEquals([
            'names' => [
                'first' => [
                    'name' => 'first name',
                    'type' => 'bruh',
                ],
                'second' => [
                    'name' => 'second name',
                    'type' => 'bruh2',
                ]
            ],
        ], $trackParserReturnValue);
    }
}
