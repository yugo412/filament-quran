<?php

namespace Yugo\FilamentQuran\Contracts;

use Yugo\FilamentQuran\Data\Surah;

interface QuranProvider
{
    public function getSurah(int $number): Surah;
}
