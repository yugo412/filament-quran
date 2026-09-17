<?php

namespace Yugo\FilamentQuran\Pages;

use Filament\Pages\Page;
use Yugo\FilamentQuran\Concerns\InteractsWithQuran;

final class QuranPage extends Page
{
    use InteractsWithQuran;

    protected string $view = 'filament-quran::pages.quran';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'quran';

    public static function getNavigationLabel(): string
    {
        return __('filament-quran::quran.navigation_label');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return (bool) config('filament-quran.page.register_navigation', true);
    }

    public function getTitle(): string
    {
        return __('filament-quran::quran.page_title');
    }
}
