<?php

namespace App\Actions;

use App\Library\Notification\Email;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserActivation
{

    public function activate(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect('/home')->with('status', 'Invalid request');
        }

        if (empty($request->data)) {
            return redirect()->refresh();
        }

        $data = unserialize(base64_decode($request->data));

        $userId = isset($data['user']) ? decode_short($data['user']) : null;
        $token = isset($data['token']) ? $data['token'] : null;

        if (empty($userId) || empty($token)) {
            return redirect('/home')->with('status', 'Invalid request');
        }

        $user = User::where([
            'id' => $userId,
            'verification_code' => $token,
        ])->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->save();

            return redirect('/login')->with('success', 'User account has been activated!');
        } else {
            return redirect('/home')->with('status', 'Error! Token verification failed');
        }
    }

    public function request(User $user)
    {
        if (empty($user->id)) {
            goto errorJump;
        }

        if (!empty($user->email_verified_at)) {
            return back()->with('status', 'User account has already active!');
        }

        $tokenData = self::init($user);

        if (empty($tokenData)) {
            goto errorJump;
        }

        $result = Email::getInstance()->initConfig([
            'receiver' => $user->email,
            'type' => 'new-user',
            'data' => [
                'fullname' => 'Sabbir Rupom',
                'url' => url('/user/activate') . "?data=$tokenData",
                'username' => $user->email,
            ],
        ])->send();

        if ($result === true) {
            return back()->with('success', 'Request has been sent! Please check your mail');
        }
        errorJump:
        return back()->with('status', 'Error! Request failure');

    }

    public static function init(User $user)
    {
        if (empty($user->id)) {
            return false;
        }
        $data = [
            'user' => encode_short($user->id),
            'token' => strtoupper(Str::random(12)),
        ];

        $user->email_verified_at = null;
        $user->verification_code = $data['token'];
        $user->save();

        return base64_encode(serialize($data));
    }
}
