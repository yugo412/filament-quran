<x-filament-panels::page>
    <x-filament::section>
        @if (count($this->providerOptions) > 1)
            @php
                $panel = \Filament\Facades\Filament::getCurrentOrDefaultPanel();
                $locale = request()->route('locale') ?? app()->getLocale();
                $currentProvider = request()->route('provider') ?? config('quran.provider');
            @endphp
            <div class="fi-quran-widget__navigation fi-quran-public__provider-switcher">
                <div class="fi-quran-widget__navigation-current">
                    <span>{{ __('filament-quran::quran.select_provider') }}</span>
                    <select
                        class="fi-quran-widget__surah-select"
                        aria-label="{{ __('filament-quran::quran.select_provider') }}"
                        onchange="window.location.href = this.value"
                    >
                        @foreach ($this->providerOptions as $provider)
                            <option
                                value="{{ route($panel->generateRouteName('pages.provider-index'), ['provider' => $provider['value'], 'locale' => $locale]) }}"
                                @selected($provider['value'] === $currentProvider)
                            >
                                {{ $provider['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        @if ($error)
            <div class="fi-quran-public__message" role="alert">
                {{ $error }}
            </div>
        @elseif ($surahs)
            @php
                $panel = \Filament\Facades\Filament::getCurrentOrDefaultPanel();
                $provider = request()->route('provider') ?? config('quran.provider');
                $locale = request()->route('locale') ?? app()->getLocale();
            @endphp
            <div class="fi-quran-public__index" aria-label="{{ __('filament-quran::quran.surah_list') }}">
                @foreach ($surahs as $surah)
                    <a
                        class="fi-quran-public__surah-card"
                        href="{{ route($panel->generateRouteName('pages.provider-locale-surah'), ['provider' => $provider, 'locale' => $locale, 'number' => $surah['number']]) }}"
                    >
                        <span class="fi-quran-public__surah-number">{{ $surah['number'] }}</span>
                        <span class="fi-quran-public__surah-details">
                            <span class="fi-quran-public__surah-latin-name">{{ $surah['latinName'] }}</span>
                            <span class="fi-quran-public__surah-meta">
                                {{ $surah['name'] }} <span aria-hidden="true">·</span> {{ $surah['verseCount'] }}
                            </span>
                        </span>
                        <span class="fi-quran-public__surah-name" dir="rtl">{{ $surah['name'] }}</span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="fi-quran-public__message" role="status">
                {{ __('filament-quran::quran.loading') }}
            </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>
