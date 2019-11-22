<?php

return [

    'subscribers' => [
        'costPremium' => 500,
    ],
    'DonateForm' => [
        'main' => [
            'bg' => 'image',
            'bgImage' => '',
            'bgVideo' => '',
            'bgColor' => '',
            'justify' => 'center',
            'light' => false,
            'minDonate' => 0,
        ],
        'header' => [
            'bgColor' => '#303030',
            'fontFamily' => '',
            'fontSize' => 14,
            'color' => '',
        ],
        'btnNext' => [
            'text' => 'Продолжить',
            'fontFamily' => '',
            'flat' => false,
            'light' => false,
            'size' => 15,
            'color' => '',
            'icon' => '',
            'bgColor' => '#232323',
        ],
        'btnBack' => [
            'fontFamily' => '',
            'flat' => true,
            'light' => false,
            'size' => 12,
            'bgColor' => '',
            'icon' => 'mdi-arrow-left-bold-circle',
        ],
        'btnCanel' => [
            'text' => 'Отмена',
            'flat' => true,
            'fontFamily' => '',
            'light' => false,
            'size' => 14,
            'bgColor' => '',
            'icon' => 'mdi-arrow-left-bold-circle',
        ],
        'btnDonat' => [
            'text' => 'Донат',
            'fontFamily' => '',
            'flat' => false,
            'light' => false,
            'size' => 15,
            'icon' => '',
            'color' => '',
            'bgColor' => '#232323',
        ],
        'other' => [
            'donatevideolimit' => 500
        ]
    ],

    'Donate' => [
        'commission' => 15,
        'minCommissionAmount' => 5,
        'minAmount' => 50,
        'percent' => true,
    ],

    'pushDonate' => [
        'main' => [
            'grid' => [
                'xs6' => true,
                'xs12' => false,
                'image' => 'right',
            ],
            'bgColor' => '',
            'duration' => 10000,
            'sound' => [
                'src' => '',
                'volume' => 5
            ]
        ],
        'image' => [
            'color' => '',
            'tile' => false,
            'size' => 175,
            'src' => 'https://media3.giphy.com/media/1AIP2ZGpgMj9tGTO7b/giphy.gif?cid=3640f6095bbfa6602e46563067ee5145',
        ],
        'video' => [
            'src' => '',
        ],
        'attachment' => [
            'src' => '',
        ],
        'name' => [
            'color' => '',
            'size' => 17,
            'font' => '',
        ],
        'amount' => [
            'color' => '',
            'size' => 17,
            'font' => '',
        ],
        'message' => [
            'color' => '',
            'size' => 17,
            'font' => '',
        ],
        'position' => [
            'title' => [
                'id' => "title",
                'x' => 0,
                'y' => 0,
                'scaleX' => 1,
                'scaleY' => 1,
                'width' => 150,
                'height' => 50,
                'angle' => 0,
                'classPrefix' => "tr2",    
            ],
            'counter' => [
                'id' => "counter",
                'x' => 100,
                'y' => 100,
                'scaleX' => 1,
                'scaleY' => 1,
                'width' => 100,
                'height' => 25,
                'angle' => 0,
                'classPrefix' => "tr2",    
            ],
            'message' => [
                'id' => "message",
                'x' => 0,
                'y' => 200,
                'scaleX' => 1,
                'scaleY' => 1,
                'width' => 200,
                'height' => 50,
                'angle' => 0,
                'classPrefix' => "tr2",    
            ],
            'attachment' => [
                'id' => "attachment",
                'x' => 0,
                'y' => 300,
                'scaleX' => 1,
                'scaleY' => 1,
                'width' => 500,
                'height' => 500,
                'angle' => 0,
                'classPrefix' => "tr2",    
            ],
        ]
    ],
];
