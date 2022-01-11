<form method="post" enctype="multipart/form-data" action="{{ route('update.profile', 'user') }}" autocomplete="off">
    @csrf
    @method('put')
    <h5 class="mb-4">@lang('translation.profile_photo')</h5>

    <div class="d-flex align-items-center">
        <div class="preview-image pt-0 mx-0" data-preview="profile_image" style="padding-right:10px;">
            <img class="img-fluid rounded-circle" alt="preview profile image" src="{{
                    $user->photo ? storage_url($user->photo) : asset('/assets/images/users/avatar-1.jpg')
                }}" data-holder-rendered="true">
        </div>
        <div class="form-group ms-3">
            <input class="show-preview custom-file-input default" title="" type="file" id="input--profile_image"
                name="profile_image" accept="image/x-png,image/jpeg,image/png">
            <div class="form-text text-center">
                @lang('translation.supported_file')
            </div>

            @error('profile_image')
            <div class="text-danger" role="alert">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <h5 class="mt-5">@lang('translation.profile_details')</h5>

    <div class="p-3 pt-2">
        <div class="mb-2 row">
            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
        </div>
        <div class="mb-2 row">
            <input type="text" class="form-control" value="{{ old('fullname', $user->name) }}" name="fullname" autocomplete="off">
            @error('fullname')
            <div class="text-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-2 row">
            <input type="text" class="form-control large-input no-rounded-corner" required name="mobile"
                value="{{ old('mobile', $user->mobile) }}" placeholder="@lang('translation.mobile_015')" autocomplete="off">
            @error('mobile')
            <div class="text-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="d-flex justify-content-start p-0">
                <button type="submit" class="btn btn-success">@lang('translation.button_save_Profile')</button>
            </div>
        </div>
    </div>

</form>