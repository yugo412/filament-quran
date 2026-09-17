<?php

namespace Yugo\FilamentQuran\Providers;

use Illuminate\Http\Client\Factory as HttpFactory;
use Yugo\FilamentQuran\Contracts\QuranCatalog;
use Yugo\FilamentQuran\Contracts\QuranProvider;
use Yugo\FilamentQuran\Data\Surah;
use Yugo\FilamentQuran\Data\SurahSummary;
use Yugo\FilamentQuran\Data\Verse;

final class EquranProvider implements QuranProvider, QuranCatalog
{
    public function __construct(
        private readonly HttpFactory $http,
        private readonly string $baseUrl,
        private readonly int $timeout,
    ) {}

    public function getSurah(int $number): Surah
    {
        $response = $this->http
            ->timeout($this->timeout)
            ->get(rtrim($this->baseUrl, '/').'/api/v2/surat/'.$number)
            ->throw()
            ->json('data');

        return new Surah(
            number: (int) $response['nomor'],
            name: (string) $response['nama'],
            latinName: (string) $response['namaLatin'],
            verseCount: (int) $response['jumlahAyat'],
            meaning: (string) $response['arti'],
            verses: array_map(
                function (array $verse): Verse {
                    return new Verse(
                        number: (int) $verse['nomorAyat'],
                        arabic: (string) $verse['teksArab'],
                        latin: (string) $verse['teksLatin'],
                        trans: [
                            'en' => null,
                            'id' => (string) $verse['teksIndonesia'],
                        ],
                    );
                },
                $response['ayat'],
            ),
            revelationPlace: $response['tempatTurun'] ?? null,
        );
    }

    /**
     * @return list<SurahSummary>
     */
    public function getSurahs(): array
    {
        $response = $this->http
            ->timeout($this->timeout)
            ->get(rtrim($this->baseUrl, '/').'/api/v2/surat')
            ->throw()
            ->json('data');

        return array_map(
            fn (array $surah): SurahSummary => new SurahSummary(
                number: (int) $surah['nomor'],
                name: (string) $surah['nama'],
                latinName: (string) $surah['namaLatin'],
                verseCount: (int) $surah['jumlahAyat'],
            ),
            $response,
        );
    }
}
