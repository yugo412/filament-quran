<?php

namespace Yugo\FilamentQuran;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Yugo\FilamentQuran\Pages\QuranPage;
use Yugo\FilamentQuran\Widgets\QuranWidget;

final class FilamentQuranPlugin implements Plugin
{
    public static function make(): static
    {
        return app(self::class);
    }

    public function getId(): string
    {
        return 'filament-quran';
    }

    public function register(Panel $panel): void
    {
        $panel->assets([
            Css::make('quran', __DIR__.'/../resources/css/quran.css'),
        ], 'yugo/filament-quran');

        $panel->widgets([
            QuranWidget::class,
        ]);

        $panel->pages([
            QuranPage::class,
        ]);
    }

    public function boot(Panel $panel): void {}
}
