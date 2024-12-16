<form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('put')

    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-light">Current Password</strong>
        <div class="form-group">
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 form-control" autofocus autocomplete="current-password" />
            <span :messages="$errors->updatePassword->get('current_password')" class="mt-2"></span>
        </div>
    </li>

    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-light">New Password</strong>
        <div class="form-group">
            <input id="update_password_password" name="password" type="password" class="mt-1 form-control" autofocus autocomplete="new-password" />
            <span :messages="$errors->updatePassword->get('password')" class="mt-2"></span>
        </div>
    </li>

    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-light">Confirm Password</strong>
        <div class="form-group">
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 form-control" autofocus autocomplete="new-password" />
            <span :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2"></span>
        </div>
    </li>

    <div class="flex items-center gap-4">
        <button class="btn btn-primary">{{ __('Save') }}</button>

        @if (session('status') === 'password-updated')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="alert alert-success alert-dismissible fade show dark:text-gray-400" role="alert">{{ __('Password updated successfully.') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
        </p>
        @endif
    </div>

</form>