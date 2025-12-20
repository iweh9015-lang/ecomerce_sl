<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    */

    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */

    // config/filesystems.php

'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app'),  // storage/app
    ],

    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),  // storage/app/public
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],

    // Contoh: Amazon S3 untuk production
    's3' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
    ],
],
];