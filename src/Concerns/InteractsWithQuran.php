<?php

namespace Yugo\FilamentQuran\Concerns;

use Throwable;
use Yugo\Quran\Data\SurahSummary;
use Yugo\Quran\Data\Verse;
use Yugo\Quran\Facades\Quran;

trait InteractsWithQuran
{
    public int $surahNumber = 1;

    public int $verseNumber = 1;

    /**
     * @var array{number: int, latinName: string, name: string, verseCount: int, meaning: string, revelationPlace: ?string, verses: list<array{number: int, arabic: string, latin: string, trans: array<string, string|null>}>}|null
     */
    public ?array $surah = null;

    /**
     * @var list<array{number: int, name: string, latinName: string, verseCount: int}>
     */
    public array $surahOptions = [];

    public ?string $error = null;

    public function mount(): void
    {
        $this->loadSurahOptions();
        $this->loadSurah();
    }

    public function selectSurah(): void
    {
        $this->verseNumber = 1;
        $this->loadSurah();
    }

    public function goTo(int $surahNumber, int $verseNumber): void
    {
        if ($surahNumber < 1 || $surahNumber > 114 || $verseNumber < 1) {
            return;
        }

        $this->surahNumber = $surahNumber;
        $this->verseNumber = $verseNumber;
        $this->loadSurah();

        $this->verseNumber = min($this->verseNumber, $this->surah['verseCount'] ?? 1);
    }

    public function nextVerse(): void
    {
        if ($this->surah === null) {
            return;
        }

        if ($this->verseNumber < $this->surah['verseCount']) {
            $this->verseNumber++;
        } elseif ($this->surahNumber < 114) {
            $this->surahNumber++;
            $this->verseNumber = 1;
            $this->loadSurah();
        }
    }

    public function previousSurah(): void
    {
        if ($this->surahNumber <= 1) {
            return;
        }

        $this->surahNumber--;
        $this->verseNumber = 1;
        $this->loadSurah();
    }

    public function nextSurah(): void
    {
        if ($this->surahNumber >= 114) {
            return;
        }

        $this->surahNumber++;
        $this->verseNumber = 1;
        $this->loadSurah();
    }

    public function isDisplayingAllVerses(): bool
    {
        return config('filament-quran.widget.display_mode', 'single') === 'all';
    }

    public function previousVerse(): void
    {
        if ($this->verseNumber > 1) {
            $this->verseNumber--;
        } elseif ($this->surahNumber > 1) {
            $this->surahNumber--;
            $this->loadSurah();
            $this->verseNumber = $this->surah['verseCount'] ?? 1;
        }
    }

    private function loadSurah(): void
    {
        try {
            $this->error = null;
            $surah = Quran::surah($this->surahNumber);

            $this->surah = [
                'number' => $surah->number,
                'latinName' => $surah->latinName,
                'name' => $surah->name,
                'verseCount' => $surah->verseCount,
                'meaning' => $surah->meaning,
                'revelationPlace' => $surah->revelationPlace,
                'verses' => array_map(
                    fn (Verse $verse): array => [
                        'number' => $verse->number,
                        'arabic' => $verse->arabic,
                        'latin' => $verse->latin,
                        'trans' => $verse->trans,
                    ],
                    $surah->verses,
                ),
            ];
        } catch (Throwable $exception) {
            report($exception);
            $this->error = __('filament-quran::quran.error');
        }
    }

    private function loadSurahOptions(): void
    {
        try {
            $this->surahOptions = array_map(
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
            $this->surahOptions = [];
        }
    }
}
