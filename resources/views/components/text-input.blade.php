@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg
                    focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-20 focus:bg-white
                    disabled:opacity-60 disabled:cursor-not-allowed
                    transition duration-150 ease-in-out
                    placeholder-gray-400'
    ]) }}
>
