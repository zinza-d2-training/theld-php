<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'images' => [
        'user' => 'images/user/default.png',
        'company' => 'images/company/default.png',
    ],
    'role' => [
        'admin' => 1,
        'ca_user' => 2
    ],

    'paginate' => [
        'maxRecord' => 10
    ]

];
