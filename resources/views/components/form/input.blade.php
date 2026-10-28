@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'help' => null,
    'required' => false,
    'disabled' => false,
])

@php
$id = $attributes->get('id', $name);
$value = $value ?? old($name);
@endphp

<div {{ $attributes->only('class')->class('mb-3') }}>
    @if ($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($required)
                <span class="text-danger" aria-hidden="true">*</span>
                <span class="visually-hidden">wajib diisi</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        @required($required)
        @disabled($disabled)
        @class(['form-control', 'is-invalid' => $errors->has($name)])
        {{ $attributes->except(['class', 'id']) }}
    >

    @if ($help)
        <div class="form-text">{{ $help }}</div>
    @endif

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>