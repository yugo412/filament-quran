<?php

return [
    'provider' => env('QURAN_PROVIDER', 'equran'),
    'cache_store' => env('QURAN_CACHE_STORE'),
    'cache_ttl' => (int) env('QURAN_CACHE_TTL', 604800),
    'providers' => [
        'equran' => [
            'base_url' => env('EQURAN_BASE_URL', 'https://equran.id'),
            'timeout' => (int) env('EQURAN_TIMEOUT', 10),
        ],
    ],
    'widget' => [
        'column_span' => env('QURAN_WIDGET_COLUMN_SPAN', 'full'),
        'display_mode' => env('QURAN_WIDGET_DISPLAY_MODE', 'single'),
    ],
];
