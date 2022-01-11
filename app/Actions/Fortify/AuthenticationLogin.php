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
        $domain = get_subdomain($request->getHost());

        if(!isset($request->domain) || $domain !== $request->domain) {
            throw ValidationException::withMessages([
                'error' => "Domain request not recognized",
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // if success login
            $user = auth()->user();

            $owner = Owner::where([
                'domain' => $domain
            ])->first();

            if(empty($owner)) {
                throw ValidationException::withMessages([
                    'error' => "Invalid user domain",
                ]);
            } elseif($owner->status <= 0) {
                throw ValidationException::withMessages([
                    'error' => "User domain is blocked",
                ]);
            }

            $isAdmin = $isOwner = $isStudent = $isTeacher = false;

            $sessionData = [
                'is_admin' => $isAdmin,
                'is_owner' => $isOwner,
                'is_student' => $isStudent,
                'is_teacher' => $isTeacher,
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

            $user->domain_now = $domain;
            $user->save();

            return $user;

        }
        $request->session()->flash('status', 'Authentication failed! Please try again');
        return null;
    }
}
