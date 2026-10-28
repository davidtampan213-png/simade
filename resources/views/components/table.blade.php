@props([
    'striped' => true,
    'hover' => true,
    'bordered' => false,
    'sm' => true,
    'responsive' => true,
    'caption' => null,
])

@php
$classes = ['table', 'align-middle', 'mb-0'];
if ($striped) $classes[] = 'table-striped';
if ($hover) $classes[] = 'table-hover';
if ($bordered) $classes[] = 'table-bordered';
if ($sm) $classes[] = 'table-sm';
@endphp

@if ($responsive)
    <div class="table-responsive">
@endif

<table {{ $attributes->class($classes) }}>
    @if ($caption)
        <caption class="caption-top text-body-secondary small py-2">{{ $caption }}</caption>
    @endif

    @isset($header)
        <thead class="table-light">
            {{ $header }}
        </thead>
    @endisset

    @isset($body)
        <tbody>
            {{ $body }}
        </tbody>
    @else
        <tbody>
            {{ $slot }}
        </tbody>
    @endisset
</table>

@if ($responsive)
    </div>
@endif