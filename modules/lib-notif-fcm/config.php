<?php

return [
    '__name' => 'lib-notif-fcm',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/lib-notif-fcm.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-notif-fcm' => ['install','update','remove'],
        'etc/cert/lib-notif-fcm' => ['install', 'remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-cache' => null
            ],
            [
                'lib-curl' => null
            ]
        ],
        'optional' => [],
        'composer' => [
            'google/apiclient' => '^2.0'
        ]
    ],
    '__inject' => [
        [
            'name' => 'libNotifFcm',
            'children' => [
                [
                    'name' => 'projectId',
                    'question' => 'Google FCM Project ID',
                    'rule' => '!^.+$!'
                ]
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'LibNotifFcm\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-notif-fcm/library'
            ]
        ],
        'files' => []
    ]
];