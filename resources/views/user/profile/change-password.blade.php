<h5 class="mb-3">@lang('translation.change_password')</h5>
<form method="post" enctype="multipart/form-data" action="{{ route('user.change.password') }}" autocomplete="off">
    @csrf
    @method('put')
    <div class="mb-2 row">
        <div class="col-12">
            <input type="password" class="form-control" id="old_password" name="old_password"
                placeholder="@lang('translation.enter_current_password')" required>
            @error('old_password')
            <div class="text-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="mb-2 row">
        <div class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
            <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror"
                id="new_password" placeholder="@lang('translation.enter_new_password')" aria-label="Password"
                aria-describedby="password-addon">
            <button class="btn btn-light " type="button" id="password-addon"><i
                    class="mdi mdi-eye-outline"></i></button>
            @error('password')
            <div class="text-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-text">@lang('translation.password_length')</div>
    </div>
    <div class="mb-2 row">
        <div class="col-12">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                placeholder="@lang('translation.retype_new_password')" required>
            @error('password_confirmation')
            <div class="text-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-start mt-4">
        <button type="submit" class="btn btn-warning">@lang('translation.button_update_password')</button>
    </div>
</form>