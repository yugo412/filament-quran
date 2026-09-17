# Filament Quran

Filament Quran provides a Quran dashboard widget for Laravel Filament applications.

Quran data is provided by [Yugo Quran Manager](https://github.com/yugo412/laravel-quran), a standalone Laravel package that can also be used outside Filament.

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

Widget settings are configured through environment variables:

```env
FILAMENT_QURAN_WIDGET_COLUMN_SPAN=full
FILAMENT_QURAN_WIDGET_DISPLAY_MODE=single
```

For complete installation instructions, provider configuration, caching, the Quran facade, and custom provider usage, see the [Yugo Quran Manager README](https://github.com/yugo412/laravel-quran#readme).

Set `FILAMENT_QURAN_WIDGET_DISPLAY_MODE` to `all` to display every verse in the active surah:

```env
FILAMENT_QURAN_WIDGET_DISPLAY_MODE=all
```

The default `single` mode displays one verse at a time with surah and verse navigation.

The widget selects a translation using the application's locale. If that locale is unavailable, it falls back to Indonesian and then to the first available translation.
