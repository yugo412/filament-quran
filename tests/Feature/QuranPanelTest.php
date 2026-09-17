<?php

use Filament\Panel;
use Illuminate\Support\Facades\Http;
use Yugo\FilamentQuran\FilamentQuranPanelProvider;
use Yugo\FilamentQuran\Pages\SurahIndexPage;
use Yugo\FilamentQuran\Pages\SurahPage;

it('configures a public Quran panel with the surah pages', function (): void {
    config()->set('filament-quran.panel.id', 'quran');
    config()->set('filament-quran.panel.path', 'quran');

    $panel = (new FilamentQuranPanelProvider(app()))->panel(Panel::make());

    expect($panel->getId())->toBe('quran')
        ->and($panel->getPath())->toBe('quran')
        ->and($panel->getAuthMiddleware())->toBe([])
        ->and($panel->getPages())->toContain(SurahIndexPage::class);
});

it('uses the panel display mode for the public Quran reader', function (): void {
    config()->set('filament-quran.panel.display_mode', 'single');

    expect((new SurahPage)->isDisplayingAllVerses())->toBeFalse();
});

it('loads the public surah index', function (): void {
    config()->set('quran.provider', 'equran');
    config()->set('quran.cache_store', 'array');

    Http::fake([
        'https://equran.id/api/v2/surat' => Http::response([
            'data' => [[
                'nomor' => 1,
                'nama' => 'الفاتحة',
                'namaLatin' => 'Al-Fatihah',
                'jumlahAyat' => 7,
            ]],
        ]),
    ]);

    $page = new SurahIndexPage;
    $page->mount();

    expect($page->surahs)->toBe([[
        'number' => 1,
        'name' => 'الفاتحة',
        'latinName' => 'Al-Fatihah',
        'verseCount' => 7,
    ]])
        ->and($page->attribution)->toBe([
            'label' => 'eQuran.id',
            'url' => 'https://equran.id',
        ]);
});
