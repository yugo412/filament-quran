<?php

namespace Yugo\FilamentQuran\Contracts;

use Yugo\FilamentQuran\Data\SurahSummary;

interface QuranCatalog
{
    /**
     * @return list<SurahSummary>
     */
    public function getSurahs(): array;
}
