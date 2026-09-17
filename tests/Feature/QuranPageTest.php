<?php

use Yugo\FilamentQuran\Pages\QuranPage;

it('registers the Quran page in navigation by default', function (): void {
    config()->set('filament-quran.page.register_navigation', true);

    expect(QuranPage::shouldRegisterNavigation())->toBeTrue();
});

it('can hide the Quran page from navigation without disabling the page', function (): void {
    config()->set('filament-quran.page.register_navigation', false);

    expect(QuranPage::shouldRegisterNavigation())->toBeFalse()
        ->and(QuranPage::getNavigationLabel())->toBeString();
});
