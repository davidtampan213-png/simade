<x-adminlte-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">{{ __('Profile') }}</h1>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title mb-0">{{ __('Profile Information') }}</h2>
        </div>
        <div class="card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h2 class="card-title mb-0">{{ __('Update Password') }}</h2>
        </div>
        <div class="card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h2 class="card-title mb-0">{{ __('Delete Account') }}</h2>
        </div>
        <div class="card-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-adminlte-layout>