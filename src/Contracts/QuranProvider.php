<?php

namespace Yugo\FilamentQuran\Contracts;

use Yugo\FilamentQuran\Data\Surah;

interface QuranProvider
{
    public function getSurah(int $number): Surah;

    /**
     * @return array{label: string, url: string}
     */
    public function getAttribution(): array;
}
