<x-filament-panels::page>
    <x-filament::section>
        @if (count($this->providerOptions) > 1)
            @php
                $panel = \Filament\Facades\Filament::getCurrentOrDefaultPanel();
                $locale = request()->route('locale') ?? app()->getLocale();
                $currentProvider = request()->route('provider') ?? config('quran.provider');
                $currentProviderLabel = collect($this->providerOptions)->firstWhere('value', $currentProvider)['label'] ?? $currentProvider;
            @endphp
            <div class="fi-quran-widget__navigation fi-quran-public__provider-switcher">
                <div class="fi-quran-widget__navigation-current">
                    <x-filament::dropdown placement="bottom" width="xs">
                        <x-slot name="trigger">
                            <x-filament::button
                                color="gray"
                                size="sm"
                                :icon="\Filament\Support\Icons\Heroicon::ChevronDown"
                                icon-position="after"
                                :aria-label="__('filament-quran::quran.select_provider')"
                            >
                                {{ $currentProviderLabel }}
                            </x-filament::button>
                        </x-slot>

                        <x-filament::dropdown.list>
                            @foreach ($this->providerOptions as $provider)
                                <x-filament::dropdown.list.item
                                    tag="a"
                                    href="{{ route($panel->generateRouteName('pages.provider-index'), ['provider' => $provider['value'], 'locale' => $locale]) }}"
                                    :color="$provider['value'] === $currentProvider ? 'primary' : 'gray'"
                                >
                                    {{ $provider['label'] }}
                                </x-filament::dropdown.list.item>
                            @endforeach
                        </x-filament::dropdown.list>
                    </x-filament::dropdown>
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
