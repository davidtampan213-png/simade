@props([
    'title',
    'value',
    'variant' => 'primary',
    'icon' => null,
    'url' => null,
    'linkLabel' => 'Lihat rincian',
])

<div {{ $attributes->class(['small-box', 'text-bg-' . $variant]) }}>
    <div class="inner">
        <h3>{{ $value }}</h3>
        <p class="mb-0">{{ $title }}</p>
    </div>

    @if ($icon)
        <div class="icon" aria-hidden="true">
            <i class="bi {{ $icon }}"></i>
        </div>
    @endif

    @if ($url)
        <a href="{{ $url }}" class="small-box-footer">
            {{ $linkLabel }} <i class="bi bi-arrow-right-circle ms-1" aria-hidden="true"></i>
        </a>
    @endif
</div>