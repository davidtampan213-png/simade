@props([
    'type' => 'info',
    'title' => null,
    'icon' => null,
    'dismissible' => true,
])

@php
$variants = [
    'success' => ['success', 'bi-check-circle-fill', 'Berhasil'],
    'danger' => ['danger', 'bi-exclamation-circle-fill', 'Gagal'],
    'warning' => ['warning', 'bi-exclamation-triangle-fill', 'Peringatan'],
    'info' => ['info', 'bi-info-circle-fill', 'Informasi'],
];
[$bootstrapVariant, $defaultIcon, $defaultTitle] = $variants[$type] ?? $variants['info'];
$iconClass = $icon ?? $defaultIcon;
$title = $title ?? $defaultTitle;
@endphp

<div {{ $attributes->class([
    'alert', 'alert-' . $bootstrapVariant, 'alert-dismissible', 'fade', 'show',
    'd-flex' => $dismissible,
    'align-items-start' => $dismissible,
    'gap-2' => $dismissible,
]) }} role="alert">
    <i class="bi {{ $iconClass }} mt-1 flex-shrink-0"></i>
    <div class="d-flex flex-column justify-content-center">
        @if ($title)
            <strong>{{ $title }}:</strong>
        @endif
        {{ $slot }}
    </div>

    @if ($dismissible)
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button>
    @endif
</div>