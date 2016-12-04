<?php

return [
    'user_model' => config('auth.providers.user.model', App\User::class),  //  user model being used
    'table' => 'usermeta',  //  table for user meta
    'routes' => [
        'add'  => 'register',
        'show' => false,
        'edit' => 'user/edit',
        'login_redirect' => '/forum'
    ],
    'avatar' => [
        'path' => '/uploads/larauser/',  //  where avatars will displayed from
        'sizes' => [
            '150x150' => ['fit', 150, 150],
        ],
        'filesystem' => [
            'driver' => 'public',
            'root' => 'uploads/larauser/',
        ],
    ]
];