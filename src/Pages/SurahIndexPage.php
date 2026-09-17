<?php

namespace Yugo\FilamentQuran\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Throwable;
use Yugo\Quran\Data\SurahSummary;
use Yugo\Quran\Facades\Quran;

final class SurahIndexPage extends Page
{
    protected string $view = 'filament-quran::pages.surah-index';

    protected static ?string $slug = '';

    /**
     * @var list<array{number: int, name: string, latinName: string, verseCount: int}>
     */
    public array $surahs = [];

    /**
     * @var array{label: string, url: string}|null
     */
    public ?array $attribution = null;

    /**
     * @var list<array{value: string, label: string}>
     */
    public array $providerOptions = [];

    public ?string $error = null;

    public function mount(): void
    {
        try {
            $this->attribution = Quran::attribution();
            $this->providerOptions = array_map(
                function (string $provider): array {
                    /** @var array{label: string} $attribution */
                    $attribution = Quran::driver($provider)->getAttribution();

                    return [
                        'value' => $provider,
                        'label' => $attribution['label'],
                    ];
                },
                array_keys(config('quran.providers', [])),
            );
            $this->surahs = array_map(
                fn (SurahSummary $surah): array => [
                    'number' => $surah->number,
                    'name' => $surah->name,
                    'latinName' => $surah->latinName,
                    'verseCount' => $surah->verseCount,
                ],
                Quran::surahs(),
            );
        } catch (Throwable $exception) {
            report($exception);
            $this->error = __('filament-quran::quran.error');
        }
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-quran::quran.navigation_label');
    }

    public static function getDefaultSlug(): string
    {
        return '';
    }

    public function getTitle(): string
    {
        return __('filament-quran::quran.page_title');
    }

    public function getHeader(): ?View
    {
        return view('filament-quran::pages.surah-index-header');
    }

    /**
     * @return array<string>
     */
    public function getPageClasses(): array
    {
        return ['fi-quran-public-page'];
    }
}
