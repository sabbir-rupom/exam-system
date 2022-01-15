<?php

namespace App\Actions\Fortify;

use App\Models\Owner;
use App\Models\OwnerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class AuthenticationLogin
{

    public static function process(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // if success login
            $user = auth()->user();

            $owner = Owner::where([
                'user_id' => $user->id
            ])->first();

            $isAdmin = $isOwner = $isStudent = $isTeacher = false;

            $sessionData = [
                'is_admin' => false,
                'is_owner' => false,
                'is_student' => false,
                'is_teacher' => false,
                'owner' => [],
                'config' => [],
                'profile' => []
            ];

            if(has_role($user, 'admin')) {
                $sessionData['is_admin'] = true;
            } else {

                if(($owner->user_id == auth()->user()->id) && has_role($user, 'owner')) {
                    $sessionData['is_owner'] = $isOwner =  true;
                    $sessionData['owner'] = [
                        'id' => $owner->id,
                        'domain' => $owner->domain,
                        'status' => boolval($owner->status)
                    ];

                }

                $ownerUser = empty($isOwner) ? OwnerUser::where([
                    'owner_id' => $owner->id,
                    'user_id' => $user->id
                ])->first() : null;

                if($ownerUser) {
                    $sessionData['is_student'] = ($ownerUser->type == OwnerUser::USER_STUDENT) && has_role($user, 'student');
                    $sessionData['is_teacher'] = ($ownerUser->type == OwnerUser::USER_TEACHER) && has_role($user, 'teacher');
                }
            }

            session($sessionData);
            return $user;

        }
        $request->session()->flash('status', 'Authentication failed! Please try again');
        return null;
    }
}
