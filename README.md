# Filament Quran

Filament Quran provides a configurable Quran data manager and a dashboard widget for Laravel Filament applications.

The Quran manager uses Laravel's manager pattern, so the data source can be changed without changing the widget or application code that reads Quran data.

## Installation

Install the package with Composer:

```bash
composer require yugo/filament-quran
```

Register the plugin in the Filament panel provider:

```php
use Filament\Panel;
use Yugo\FilamentQuran\FilamentQuranPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            FilamentQuranPlugin::make(),
        ]);
}
```

Publish the configuration file when you need to customize the defaults:

```bash
php artisan vendor:publish --tag=filament-quran-config
```

Publish Filament assets after installing or updating the package:

```bash
php artisan filament:assets
```

The plugin adds the Quran widget to the configured Filament dashboard.

## Configuration

The package reads its provider settings from environment variables:

```env
QURAN_PROVIDER=ummahapi
QURAN_CACHE_STORE=
QURAN_CACHE_TTL=604800
EQURAN_BASE_URL=https://equran.id
EQURAN_TIMEOUT=10
QURAN_WIDGET_COLUMN_SPAN=full
QURAN_WIDGET_DISPLAY_MODE=single
```

Set `QURAN_WIDGET_DISPLAY_MODE` to `all` to display every verse in the active surah:

```env
QURAN_WIDGET_DISPLAY_MODE=all
```

The default `single` mode displays one verse at a time with surah and verse navigation.

## Quran data library

The package exposes a `Quran` facade for fetching normalized Quran data from the configured provider:

```php
use Yugo\FilamentQuran\Facades\Quran;

$surah = Quran::surah(1);
$verse = $surah->verse(10);
```

The returned `Surah` object contains:

- `number`
- `name`
- `latinName`
- `verseCount`
- `meaning`
- `revelationPlace`
- `verses`

Each item in `verses` is a `Verse` object containing:

- `number`
- `arabic`
- `latin`
- `trans`, an associative array keyed by locale, such as `en` and `id`

The widget selects a translation using the application's locale. If that locale is unavailable, it falls back to Indonesian and then to the first available translation.

Surah responses are cached using the configured Laravel cache store and TTL.
Use `verse(int $number)` to select a verse from the loaded surah without making another provider request. It returns `null` when the verse does not exist.

## Providers

### eQuran.id

Data provided by [eQuran.id](https://equran.id).

### UmmahAPI

Data provided by [UmmahAPI](https://ummahapi.com).

### Custom providers

Custom providers can implement the `QuranProvider` contract and be registered through the manager:

```php
use Yugo\FilamentQuran\Contracts\QuranProvider;
use Yugo\FilamentQuran\Facades\Quran;

Quran::extend('custom', fn (): QuranProvider => new CustomQuranProvider);
```

Select the custom provider in configuration:

```env
QURAN_PROVIDER=custom
```

A provider must implement:

```php
public function getSurah(int $number): Surah;

/**
 * @return array{label: string, url: string}
 */
public function getAttribution(): array;
```
