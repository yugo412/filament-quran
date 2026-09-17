<header class="fi-header fi-quran-public__index-header">
    <h1 class="fi-header-heading">
        {{ $this->getHeading() }}
    </h1>

    @if ($this->attribution)
        <p class="fi-quran-widget__attribution" role="note">
            {{ __('filament-quran::quran.attribution') }}
            <a href="{{ $this->attribution['url'] }}" target="_blank" rel="noreferrer noopener">
                {{ $this->attribution['label'] }}
            </a>
        </p>
    @endif

</header>
