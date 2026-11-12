@props([
    'title',
    'value',
    'variant' => 'primary',
    'icon' => null,
    'description' => null,
    'subtitle' => null,
    'url' => null,
    'linkLabel' => 'Lihat rincian',
    'linkText' => null,
])

@php
    $sub = $subtitle ?? $description;
    $link = $linkText ?? $linkLabel;
    // Normalize icon class: if it starts with 'bi ', leave it; if 'bi-', prefix with 'bi '; else 'bi bi-'
    $iconClass = $icon;
    if ($icon && !str_starts_with($icon, 'bi ')) {
        $iconClass = str_starts_with($icon, 'bi-') ? 'bi ' . $icon : 'bi bi-' . $icon;
    }
@endphp

<div {{ $attributes->class(['x-small-box', 'variant-' . $variant]) }}>
    <div class="d-flex align-items-start justify-content-between gap-2 flex-grow-1">
        <div class="x-small-box-inner d-flex flex-column justify-content-between h-100">
            <div>
                <p class="x-small-box-title mb-1">{{ $title }}</p>
                <h3 class="x-small-box-value">{{ $value }}</h3>
            </div>
            @if ($sub)
                <small class="x-small-box-meta text-truncate">{{ $sub }}</small>
            @endif
        </div>

        @if ($icon)
            <div class="x-small-box-icon icon-{{ $variant }} flex-shrink-0" aria-hidden="true">
                <i class="{{ $iconClass }}"></i>
            </div>
        @endif
    </div>

    @if ($url)
        <a href="{{ $url }}" class="x-small-box-footer">
            <span>{{ $link }}</span>
            <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
        </a>
    @endif
</div>