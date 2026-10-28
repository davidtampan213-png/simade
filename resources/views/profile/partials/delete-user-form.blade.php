<section x-data="{ show: @js($errors->userDeletion->isNotEmpty()) }"
         x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null"
         x-on:close.window="show = false"
         x-on:keydown.escape.window="show = false">
    <p class="text-muted mb-4">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>

    <button type="button" class="btn btn-danger btn-sm" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
        {{ __('Delete Account') }}
    </button>

    <div class="modal fade show" role="dialog" aria-modal="true" aria-labelledby="confirm-user-deletion-title" x-show="show" x-cloak>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h2 id="confirm-user-deletion-title" class="modal-title fs-5">{{ __('Are you sure you want to delete your account?') }}</h2>
                        <button type="button" class="btn-close" x-on:click="$dispatch('close')" aria-label="{{ __('Close') }}"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted mb-3">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>

                        <div>
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" name="password" type="password" class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif" placeholder="{{ __('Password') }}">
                            @if($errors->userDeletion->has('password'))
                                <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" x-show="show" x-cloak></div>
</section>
