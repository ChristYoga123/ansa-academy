<?php 
return [
    [
        'menu' => 'Beranda',
        'url' => '/',
    ],
    [
        'menu' => 'Program',
        'url' => '/program*',
        'children' => [
            [
                'menu' => 'Mentoring 101',
                'url' => '/program/mentoring-101',
            ],
            [
                'menu' => 'Kelas ANSA',
                'url' => '/program/kelas-ansa',
            ],
            [
                'menu' => 'Proofreading',
                'url' => '/program/proofreading',
            ]
        ]
    ],
    [
        'menu' => 'Event',
        'url' => '/event',
    ],
    [
        'menu' => 'Lomba',
        'url' => '/lomba',
    ],
    [
        'menu' => 'Blog',
        'url' => '/blog',
    ]
]
?>