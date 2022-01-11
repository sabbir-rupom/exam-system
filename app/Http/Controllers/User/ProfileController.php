<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Library\Resource\FileStorage;
use App\Models\ResourceType;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function viewProfile(Request $request)
    {

        $user = auth()->user();

        if (empty($user)) {
            return back()->with('status', __('alet.user_not_found'));
        }

        if ($request->session()->has('password_change')) {
            $passwordChange = intval($request->session()->get('password_change'));
            $request->session()->forget('password_change');
        } else {
            $passwordChange = false;
        }

        return view('user.profile.detail', [
            'user' => $user,
            'passwordChange' => $passwordChange,
        ]);

    }

    public function process(Request $request, string $type = 'user')
    {

        return $this->updateBasicProfile($request);

    }

    /**
     * Update user profile information
     *
     * @param Request $request
     * @return void
     */
    protected function updateBasicProfile(Request $request)
    {

        $validationRules = [
            'fullname' => 'required|string|max:100',
            'mobile' => ['required', 'regex:/^(?:\+88|88)?(01[3-9]\d{8})$/'],
        ];
        if ($request->hasFile('profile_image')) {
            $validationRules['profile_image'] = 'required|mimes:jpg,png,jpeg|max:2048';
        }

        $this->validate($request, $validationRules);

        $user = auth()->user();

        $uploadResult = null;
        if ($request->hasFile('profile_image')) {
            if ($user->photo) {
                FileStorage::remove($user->photo);
            }
            $uploadResult = FileStorage::getInstance()->setConfig([
                'path' => 'user/image',
                'file_type' => 1,
            ])->store($request->file('profile_image'));

        }

        $userMobile = trim($request->mobile);

        if ($uploadResult) {
            $userImage = $uploadResult['path'];
        } else {
            $userImage = null;
        }

        $user->name = $request->fullname;
        $user->photo = empty($userImage) ? $user->photo : $userImage;

        if($user->mobile != $userMobile && User::where('mobile', $userMobile)->doesntexist()) {
            $user->mobile = $userMobile;
        }

        $user->save();

        return back()->with('success', __('alert.user_profile_updated'));
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'old_password' => 'required',
        ]);

        $user = User::find(auth()->user()->id);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('status', __('alert.invalid_password'));
        }

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);

        return back()->with('success', __('alert.password_changed'));
    }
}
