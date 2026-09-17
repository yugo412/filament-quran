<?php

namespace Yugo\FilamentQuran\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Yugo\FilamentQuran\Concerns\InteractsWithQuran;

final class SurahPage extends Page
{
    use InteractsWithQuran;

    protected string $view = 'filament-quran::pages.surah';

    protected static ?string $slug = 'surah/{number}';

    public function mount(int $number): void
    {
        $this->initializeQuran($number);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return $this->surah['latinName'] ?? __('filament-quran::quran.page_title');
    }

    public function getHeader(): ?View
    {
        return view('filament-quran::pages.surah-header');
    }

    protected function getQuranDisplayMode(): string
    {
        return (string) config('filament-quran.panel.display_mode', 'all');
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['fi-quran-public-page'];
    }
}
