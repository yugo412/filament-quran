<?php

return [
    'widget' => [
        'column_span' => env('FILAMENT_QURAN_WIDGET_COLUMN_SPAN', 'full'),
        'display_mode' => env('FILAMENT_QURAN_WIDGET_DISPLAY_MODE', 'single'),
    ],

    'page' => [
        'register_navigation' => env('FILAMENT_QURAN_PAGE_REGISTER_NAVIGATION', true),
        'display_mode' => env('FILAMENT_QURAN_PAGE_DISPLAY_MODE', 'all'),
    ],

    'panel' => [
        'id' => env('FILAMENT_QURAN_PANEL_ID', 'quran'),
        'path' => env('FILAMENT_QURAN_PANEL_PATH', 'quran'),
        'display_mode' => env('FILAMENT_QURAN_PANEL_DISPLAY_MODE', 'all'),
    ],
];
