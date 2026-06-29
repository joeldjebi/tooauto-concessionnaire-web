<?php

return [
    'access_key' => env('WAS_ACCESS_KEY'),
    'secret_key' => env('WAS_SECRET_KEY'),
    'bucket' => env('WASABI_BUCKET'),
    'endpoint' => env('WASABI_ENDPOINT'),
    'region' => env('WASABI_REGION'),
    'url' => env('WASABI_URL'),
    'avatar_directory' => 'images/avatar',
    'concessionnaire_logo_directory' => 'concessionnaire/logo',
    'concessionnaire_cover_directory' => 'concessionnaire/cover',
    'vehicule_image_directory' => 'images/vehicules',
    'vehicule_file_directory' => 'fichiers/vehicules',
];
