<?php

use Illuminate\Support\Facades\Http;
use Yugo\FilamentQuran\Widgets\QuranWidget;

beforeEach(function (): void {
    config()->set('quran.provider', 'equran');
});

it('moves to the next surah after the last verse', function (): void {
    config()->set('quran.cache_store', 'array');

    Http::fake([
        'https://equran.id/api/v2/surat/1' => Http::response([
            'data' => [
                'nomor' => 1,
                'nama' => 'الفاتحة',
                'namaLatin' => 'Al-Fatihah',
                'jumlahAyat' => 1,
                'arti' => 'Pembukaan',
                'ayat' => [[
                    'nomorAyat' => 1,
                    'teksArab' => 'آية',
                    'teksLatin' => 'Ayah',
                    'teksIndonesia' => 'Ayat',
                ]],
            ],
        ]),
        'https://equran.id/api/v2/surat/2' => Http::response([
            'data' => [
                'nomor' => 2,
                'nama' => 'البقرة',
                'namaLatin' => 'Al-Baqarah',
                'jumlahAyat' => 1,
                'arti' => 'Sapi Betina',
                'ayat' => [[
                    'nomorAyat' => 1,
                    'teksArab' => 'آية',
                    'teksLatin' => 'Ayah',
                    'teksIndonesia' => 'Ayat',
                ]],
            ],
        ]),
    ]);

    $widget = new QuranWidget;
    $widget->mount();
    $widget->nextVerse();

    expect($widget->surahNumber)->toBe(2)
        ->and($widget->verseNumber)->toBe(1)
        ->and($widget->surah['latinName'] ?? null)->toBe('Al-Baqarah');

    $widget->previousSurah();

    expect($widget->surahNumber)->toBe(1)
        ->and($widget->verseNumber)->toBe(1)
        ->and($widget->surah['latinName'] ?? null)->toBe('Al-Fatihah');
});

it('supports displaying every verse in a surah', function (): void {
    config()->set('filament-quran.widget.display_mode', 'all');

    expect((new QuranWidget)->isDisplayingAllVerses())->toBeTrue();
});

it('can restore a saved reading position', function (): void {
    config()->set('quran.cache_store', 'array');

    Http::fake([
        'https://equran.id/api/v2/surat/2' => Http::response([
            'data' => [
                'nomor' => 2,
                'nama' => 'البقرة',
                'namaLatin' => 'Al-Baqarah',
                'jumlahAyat' => 2,
                'arti' => 'Sapi Betina',
                'ayat' => [
                    [
                        'nomorAyat' => 1,
                        'teksArab' => 'آية',
                        'teksLatin' => 'Ayah',
                        'teksIndonesia' => 'Ayat',
                    ],
                    [
                        'nomorAyat' => 2,
                        'teksArab' => 'آية',
                        'teksLatin' => 'Ayah',
                        'teksIndonesia' => 'Ayat',
                    ],
                ],
            ],
        ]),
    ]);

    $widget = new QuranWidget;
    $widget->goTo(2, 2);

    expect($widget->surahNumber)->toBe(2)
        ->and($widget->verseNumber)->toBe(2)
        ->and($widget->surah['latinName'] ?? null)->toBe('Al-Baqarah');
});
