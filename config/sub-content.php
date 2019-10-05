<?php

return [
    'default-content' => [
        [
            'component' => 'audio-features',
        ],
        [
            'component' => 'player-controls',
        ],
        [
            'component' => 'track-info',
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
