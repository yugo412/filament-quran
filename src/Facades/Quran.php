<?php

namespace Yugo\FilamentQuran\Facades;

use Illuminate\Support\Facades\Facade;
use Yugo\FilamentQuran\QuranManager;

final class Quran extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return QuranManager::class;
    }
}
