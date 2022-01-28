<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationLogin
{

    public static function process(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /**
             * if success login
             */
            $user = auth()->user();

            // $isAdmin = $isStudent = $isTeacher = false;

            $sessionData = [
                'is_admin' => false,
                'is_student' => false,
                'is_teacher' => false,
                'config' => [],
                'profile' => [],
            ];

            if (has_role($user, 'admin')) {
                $sessionData['is_admin'] = true;
            } else {
                $sessionData['is_student'] = has_role($user, 'student');
                $sessionData['is_teacher'] = has_role($user, 'teacher');

            }
            session($sessionData);
            return $user;
        }

        /**
         * if unsuccessful login
         */
        $request->session()->flash('status', 'Authentication failed! Please try again');
        return null;
    }
}
