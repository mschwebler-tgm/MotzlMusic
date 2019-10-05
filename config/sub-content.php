<?php

return [
    'default-content' => [
        [
            'component' => 'audio-features',
            'randomId' => 1,  // random id is used as key in vue. it has no other purposes
        ],
        [
            'component' => 'player-controls',
            'randomId' => 2,
        ],
        [
            'component' => 'track-info',
            'randomId' => 3,
        ],
    ],
    'available-content' => [
        [
            'label' => 'Player Controls',
            'items' => [
                [
                    'label' => 'Medium Player',
                    'component' => 'player-controls',
                ],
            ],
        ],
        [
            'label' => 'Info',
            'items' => [
                [
                    'label' => 'Track Information',
                    'component' => 'track-info',
                ],
            ],
        ],
        [
            'label' => 'Visualization',
            'items' => [
                [
                    'label' => 'Audio Analysis (Spider Web)',
                    'component' => 'audio-features',
                ],
            ],
        ],
    ],
];
