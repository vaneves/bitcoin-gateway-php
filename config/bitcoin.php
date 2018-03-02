<?php 

return [
    'host' => env('BITCOIN_HOST', '127.0.0.1'),
    'port' => env('BITCOIN_PORT', '18332'),
    'username' => env('BITCOIN_USERNAME', 'user'),
    'password' => env('BITCOIN_PASSWORD', 'pass'),
    'account' => env('BITCOIN_DEFAULT_ACCOUNT', 'vaneves'),
];