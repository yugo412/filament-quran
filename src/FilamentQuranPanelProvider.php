<?php

namespace Yugo\FilamentQuran;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;
use Yugo\FilamentQuran\Http\Middleware\SetQuranLocale;
use Yugo\FilamentQuran\Pages\SurahIndexPage;
use Yugo\FilamentQuran\Pages\SurahPage;

final class FilamentQuranPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id((string) config('filament-quran.panel.id', 'quran'))
            ->path(trim((string) config('filament-quran.panel.path', 'quran'), '/'))
            ->brandName(__('filament-quran::quran.panel_brand'))
            ->navigation(false)
            ->topbar(false)
            ->maxContentWidth('full')
            ->middleware([SetQuranLocale::class])
            ->routes(function (): void {
                $providers = array_keys(config('quran.providers', []));

                if ($providers === []) {
                    return;
                }

                Route::name('pages.')->group(function () use ($providers): void {
                    Route::get('/{provider}/{locale?}', SurahIndexPage::class)
                        ->whereIn('provider', $providers)
                        ->name('provider-index');

                    Route::get('/{provider}/surah/{number}', SurahPage::class)
                        ->whereIn('provider', $providers)
                        ->name('provider-surah');

                    Route::get('/{provider}/{locale}/surah/{number}', SurahPage::class)
                        ->whereIn('provider', $providers)
                        ->name('provider-locale-surah');

                    Route::get('/{locale}', SurahIndexPage::class)
                        ->name('locale-index');

                    Route::get('/{locale}/surah/{number}', SurahPage::class)
                        ->name('locale-surah');
                });
            })
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): HtmlString => new HtmlString(<<<'HTML'
                    <style>
                        .fi-quran-public-page .fi-header {
                            align-items: center;
                            display: grid;
                            grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
                            text-align: center;
                        }

                        .fi-quran-public-page .fi-header > .fi-header-heading {
                            grid-column: 2;
                            grid-row: 1;
                            text-align: center;
                        }

                        .fi-quran-public-page .fi-quran-public__home-link {
                            align-items: center;
                            display: inline-flex;
                            gap: 0.5rem;
                            grid-column: 1;
                            grid-row: 1;
                            justify-self: start;
                        }

                        .fi-quran-public-page .fi-quran-public__index-header {
                            display: flex;
                            flex-direction: column;
                            gap: 0.5rem;
                        }

                        .fi-quran-public-page .fi-quran-public__provider-switcher {
                            align-items: center;
                            border-bottom: 1px solid rgb(229 231 235);
                            display: flex;
                            justify-content: center;
                            margin-bottom: 1.5rem;
                            padding-bottom: 1rem;
                        }
                    </style>
                    HTML),
            )
            ->assets([
                Css::make('quran', __DIR__.'/../resources/css/quran.css'),
            ], 'yugo/filament-quran')
            ->pages([
                SurahIndexPage::class,
                SurahPage::class,
            ])
            ->widgets([]);
    }
}
