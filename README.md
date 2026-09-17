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
It also registers a dedicated Quran page with the `quran` slug in the active Filament panel.

## Configuration

Widget settings are configured through environment variables:

```env
FILAMENT_QURAN_WIDGET_COLUMN_SPAN=full
FILAMENT_QURAN_WIDGET_DISPLAY_MODE=single
FILAMENT_QURAN_PAGE_REGISTER_NAVIGATION=true
FILAMENT_QURAN_PAGE_DISPLAY_MODE=all
FILAMENT_QURAN_PANEL_ID=quran
FILAMENT_QURAN_PANEL_PATH=quran
FILAMENT_QURAN_PANEL_DISPLAY_MODE=all
```

For complete installation instructions, provider configuration, caching, the Quran facade, and custom provider usage, see the [Yugo Quran Manager README](https://github.com/yugo412/laravel-quran#readme).

Set `FILAMENT_QURAN_WIDGET_DISPLAY_MODE` to `all` to display every verse in the active surah:

```env
FILAMENT_QURAN_WIDGET_DISPLAY_MODE=all
```

The default `single` mode displays one verse at a time with surah and verse navigation.

The standalone Quran page defaults to `all` and can be changed with `FILAMENT_QURAN_PAGE_DISPLAY_MODE`.
The public Quran panel also defaults to `all` and can be changed with `FILAMENT_QURAN_PANEL_DISPLAY_MODE`.

Set `FILAMENT_QURAN_PAGE_REGISTER_NAVIGATION` to `false` to hide the page from panel navigation. The page route remains directly accessible in the active panel.

The widget selects a translation using the application's locale. If that locale is unavailable, it falls back to Indonesian and then to the first available translation.

## Public Quran panel

The package also registers a public Filament panel with a surah index and reader pages. It does not enable login or authentication middleware.

The panel defaults to `/quran`. It uses the configured provider and application's default locale when no segments are provided. A provider and locale can be forced with `/quran/{provider}/{locale}`. The panel path can be configured with:

```env
FILAMENT_QURAN_PANEL_ID=quran
FILAMENT_QURAN_PANEL_PATH=quran
FILAMENT_QURAN_PANEL_DISPLAY_MODE=all
```

The panel homepage displays surahs in a responsive grid. Selecting a surah opens its reader at `/{panel-path}/{provider}/{locale}/surah/{number}`. Both segments are optional; when present, they force the provider and application's locale for that request.
