@props([
    'title' => null,
    'subtitle' => null,
    'variant' => null,
    'outline' => false,
    'flush' => false,
])

@php
$classes = ['card'];
if ($outline || $variant) {
    $classes[] = 'card-outline';
    if ($variant) {
        $classes[] = 'card-' . $variant;
    }
}
@endphp

<div {{ $attributes->class($classes) }}>
    @if (isset($header))
        <div class="card-header">
            {{ $header }}
        </div>
    @elseif ($title || $subtitle || isset($tools))
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                @if ($title)
                    <h3 class="card-title mb-0 fs-6 fw-semibold text-dark">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="card-subtitle text-body-secondary small mb-0 mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($tools)
                <div class="card-tools d-flex align-items-center gap-2 ms-auto">
                    {{ $tools }}
                </div>
            @endisset
        </div>
    @endif

    <div @class(['card-body', 'p-0' => $flush])>
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer bg-transparent border-top">
            {{ $footer }}
        </div>
    @endisset
</div>