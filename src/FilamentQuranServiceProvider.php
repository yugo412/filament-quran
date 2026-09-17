<?php

namespace Yugo\FilamentQuran;

use Illuminate\Support\ServiceProvider;

final class FilamentQuranServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/filament-quran.php', 'filament-quran');

    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/filament-quran.php' => config_path('filament-quran.php'),
        ], 'filament-quran-config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-quran');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-quran');
    }
}
