<header class="fi-header fi-quran-public__page-header">
    @php
        $panel = \Filament\Facades\Filament::getCurrentOrDefaultPanel();
        $provider = request()->route('provider') ?? config('quran.provider');
        $locale = request()->route('locale') ?? app()->getLocale();
    @endphp
    <a
        href="{{ route($panel->generateRouteName('pages.provider-index'), ['provider' => $provider, 'locale' => $locale]) }}"
        class="fi-quran-public__home-link"
        aria-label="{{ __('filament-quran::quran.surah_list') }}"
    >
        <x-filament::icon icon="heroicon-m-arrow-left" class="size-5" />
        <span>{{ __('filament-quran::quran.surah_list') }}</span>
    </a>

    <h1 class="fi-header-heading">
        {{ $this->getHeading() }}
    </h1>
</header>
