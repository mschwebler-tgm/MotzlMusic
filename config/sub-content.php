<?php

return [
    'default-content' => [
        [
            'component' => 'sub-content-audio-features',
            'randomId' => 1,  // random id is used as key in vue. it has no other purposes
        ],
        [
            'component' => 'sub-content-player-controls',
            'randomId' => 2,
        ],
        [
            'component' => 'sub-content-track-info',
            'randomId' => 3,
        ],
    ],
    'available-content' => [
        [
            'label' => 'Player Controls',
            'items' => [
                [
                    'label' => 'Medium Player',
                    'component' => 'sub-content-player-controls',
                ],
                [
                    'label' => 'Current Track Queue',
                    'component' => 'sub-content-current-tracks',
                ],
            ],
        ],
        [
            'label' => 'Info',
            'items' => [
                [
                    'label' => 'Track Information',
                    'component' => 'sub-content-track-info',
                ],
            ],
        ],
        [
            'label' => 'Visualization',
            'items' => [
                [
                    'label' => 'Audio Analysis (Spider Web)',
                    'component' => 'sub-content-audio-features',
                ],
            ],
        ],
    ],
];
