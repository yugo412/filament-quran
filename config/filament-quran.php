<?php

return [
    'widget' => [
        'column_span' => env('FILAMENT_QURAN_WIDGET_COLUMN_SPAN', 'full'),
        'display_mode' => env('FILAMENT_QURAN_WIDGET_DISPLAY_MODE', 'single'),
    ],

    'page' => [
        'register_navigation' => env('FILAMENT_QURAN_PAGE_REGISTER_NAVIGATION', true),
    ],
];
