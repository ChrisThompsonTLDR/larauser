<?php

return [
    'user_model' => config('auth.providers.user.model', App\User::class),  //  user model being used
    'table'      => 'user_meta',  //  table for user meta
];