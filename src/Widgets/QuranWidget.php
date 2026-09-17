<?php

namespace Yugo\FilamentQuran\Widgets;

use Filament\Widgets\Widget;
use Yugo\FilamentQuran\Concerns\InteractsWithQuran;

final class QuranWidget extends Widget
{
    use InteractsWithQuran;

    protected string $view = 'filament-quran::widgets.quran-widget';

    protected int|string|array $columnSpan = 'full';

    public function mount(): void
    {
        $this->initializeQuran();
    }

    public function getColumnSpan(): int|string|array
    {
        return config('filament-quran.widget.column_span', 'full');
    }

    protected function getQuranDisplayMode(): string
    {
        return (string) config('filament-quran.widget.display_mode', 'single');
    }
}
