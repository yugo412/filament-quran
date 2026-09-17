<div
    x-data="{
        storageKey: 'filament-quran.reading-position',
        restorePosition: @js(request()->route('number') === null),
        init() {
            this.$wire.$watch('surahNumber', () => this.savePosition())
            this.$wire.$watch('verseNumber', () => this.savePosition())

            try {
                const position = JSON.parse(window.localStorage.getItem(this.storageKey) ?? 'null')

                if (this.restorePosition && position?.surah && position?.verse) {
                    this.$wire.goTo(position.surah, position.verse)
                }
            } catch (error) {
                window.localStorage.removeItem(this.storageKey)
            }
        },
        savePosition() {
            window.localStorage.setItem(this.storageKey, JSON.stringify({
                surah: this.$wire.surahNumber,
                verse: this.$wire.verseNumber,
            }))
        },
    }"
>
    @if ($error)
        <div class="text-sm text-danger-600 dark:text-danger-400" role="alert">
            {{ $error }}
        </div>
    @elseif ($surah)
        @php
            $verses = $this->isDisplayingAllVerses()
                ? $surah['verses']
                : [$surah['verses'][$verseNumber - 1] ?? null];
        @endphp

        <div class="fi-quran-widget space-y-8">
            <div class="fi-quran-widget__navigation">
                <button type="button" class="fi-quran-widget__navigation-button" wire:click="previousSurah" wire:loading.attr="disabled" aria-label="{{ __('filament-quran::quran.previous_surah') }}" @disabled($surahNumber === 1)>
                    <x-filament::icon icon="heroicon-m-chevron-left" class="size-5" />
                    <span class="hidden sm:inline">{{ __('filament-quran::quran.previous_surah') }}</span>
                </button>

                <div class="fi-quran-widget__navigation-current">
                    @if ($surahOptions)
                        <label class="sr-only" for="quran-surah-select-{{ $this->getId() }}">
                            {{ __('filament-quran::quran.select_surah') }}
                        </label>
                        <select
                            id="quran-surah-select-{{ $this->getId() }}"
                            class="fi-quran-widget__surah-select"
                            wire:model.live="surahNumber"
                            wire:change="selectSurah"
                        >
                            @foreach ($surahOptions as $option)
                                <option value="{{ $option['number'] }}">
                                    {{ $option['number'] }}. {{ $option['latinName'] }} ({{ $option['name'] }})
                                </option>
                            @endforeach
                        </select>
                    @else
                        <span>{{ $surah['latinName'] }}</span>
                    @endif
                    @if (! $this->isDisplayingAllVerses())
                        <span class="text-gray-400" aria-hidden="true">·</span>
                        <span>{{ __('filament-quran::quran.verse_number', ['number' => $verseNumber]) }}</span>
                    @endif
                </div>

                <button type="button" class="fi-quran-widget__navigation-button" wire:click="nextSurah" wire:loading.attr="disabled" aria-label="{{ __('filament-quran::quran.next_surah') }}" @disabled($surahNumber === 114)>
                    <span class="hidden sm:inline">{{ __('filament-quran::quran.next_surah') }}</span>
                    <x-filament::icon icon="heroicon-m-chevron-right" class="size-5" />
                </button>
            </div>

            <div class="fi-quran-widget__header space-y-1 text-center">
                <p class="fi-quran-widget__surah-name font-serif text-3xl leading-tight text-gray-700 dark:text-gray-200" dir="rtl">
                    {{ $surah['name'] }}
                </p>
                <h3 class="text-xl font-semibold text-gray-950 dark:text-white">
                    {{ $surah['latinName'] }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $surah['revelationPlace'] }} <span aria-hidden="true">·</span> {{ $surah['verseCount'] }}
                </p>
            </div>

            <div class="fi-quran-widget__verses">
                @foreach ($verses as $verse)
                    @if ($verse)
                        <article id="verse-{{ $verse['number'] }}" class="fi-quran-widget__verse space-y-5">
                            <div class="fi-quran-widget__arabic-row flex items-start justify-end gap-3">
                                <a
                                    href="#verse-{{ $verse['number'] }}"
                                    class="fi-quran-widget__verse-anchor mt-2 inline-flex size-8 shrink-0 items-center justify-center rounded-full border border-amber-600/50 text-sm tabular-nums text-amber-700 dark:border-amber-400/50 dark:text-amber-300"
                                    aria-label="{{ __('filament-quran::quran.verse_link', ['number' => $verse['number']]) }}"
                                    x-on:click.prevent="window.location.hash = 'verse-{{ $verse['number'] }}'"
                                >
                                    {{ $verse['number'] }}
                                </a>
                                <p class="fi-quran-widget__arabic min-w-0 text-right text-3xl leading-[2.1] text-gray-950 sm:text-4xl dark:text-white" dir="rtl">
                                    {{ $verse['arabic'] }}
                                </p>
                            </div>
                            <p class="fi-quran-widget__latin text-base leading-relaxed text-teal-600 dark:text-teal-400">
                                {{ $verse['latin'] }}
                            </p>
                            <p class="fi-quran-widget__translation text-lg leading-relaxed text-gray-700 dark:text-gray-300">
                                {{ data_get($verse['trans'], app()->getLocale()) ?? data_get($verse['trans'], substr(app()->getLocale(), 0, 2)) ?? data_get($verse['trans'], 'id') ?? (array_values($verse['trans'])[0] ?? '') }}
                            </p>
                        </article>
                    @endif
                @endforeach
            </div>

            @if (! $this->isDisplayingAllVerses())
                <div class="fi-quran-widget__verse-navigation">
                    <button type="button" class="fi-quran-widget__navigation-button" wire:click="previousVerse" wire:loading.attr="disabled" aria-label="{{ __('filament-quran::quran.previous_verse') }}" @disabled($surahNumber === 1 && $verseNumber === 1)>
                        <x-filament::icon icon="heroicon-m-chevron-left" class="size-5" />
                        {{ __('filament-quran::quran.previous_verse') }}
                    </button>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('filament-quran::quran.verse_of', ['current' => $verseNumber, 'total' => $surah['verseCount']]) }}
                    </span>
                    <button type="button" class="fi-quran-widget__navigation-button" wire:click="nextVerse" wire:loading.attr="disabled" aria-label="{{ __('filament-quran::quran.next_verse') }}" @disabled($surahNumber === 114 && $verseNumber === $surah['verseCount'])>
                        {{ __('filament-quran::quran.next_verse') }}
                        <x-filament::icon icon="heroicon-m-chevron-right" class="size-5" />
                    </button>
                </div>
            @endif

            @php
                $providerUrl = config('quran.providers.'.config('quran.provider').'.base_url');
                $providerName = parse_url($providerUrl, PHP_URL_HOST) ?: $providerUrl;
            @endphp
            <p class="fi-quran-widget__attribution">
                {{ __('filament-quran::quran.attribution') }}
                <a href="{{ $providerUrl }}" target="_blank" rel="noreferrer noopener">{{ $providerName }}</a>
            </p>
        </div>
    @else
        <div class="text-sm text-gray-500 dark:text-gray-400" role="status">
            {{ __('filament-quran::quran.loading') }}
        </div>
    @endif
</div>
