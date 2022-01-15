<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laratrust\Traits\LaratrustUserTrait;
use Yadahan\AuthenticationLog\AuthenticationLogable;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable, AuthenticationLogable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'photo',
        'mobile',
        'password',
        'verification_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User Role is defined according to database table
     */
    const ROLE_OWNER = 1;
    const ROLE_TEACHER = 2;
    const ROLE_STUDENT = 3;

    /**
     * Types of users
     * --- Admin types are excluded
     */
    const ROLE_TYPES = [
        self::ROLE_STUDENT => 'student',
        self::ROLE_TEACHER => 'teacher',
        self::ROLE_OWNER => 'owner',
    ];

    /**
     * Get user list by user role
     *
     * @param integer $role
     * @param boolean $pagination
     * @param Request $request
     * @return void
     */
    public static function getUsers($pagination = true, Request $request = null, $all = true)
    {

        $users = User::select('id', 'name', 'email', 'username', 'mobile', 'email_verified_at');

        if ($request && isset($request->name_key) && !empty($request->name_key)) {
            $users = $users->where(function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name_key}%")
                    ->orWhere('username', 'like', "%{$request->name_key}%")
                    ->orWhere('email', 'like', "%{$request->name_key}%");
            });
        }

        if(!$all) {
            // Exclude admins
            $admins = DB::table('role_user')->select('user_id')->where('role_id', 1)->get()->toArray();
            if (!empty($admins)) {
                $adminUsers = array_column($admins, 'user_id');
            }
            $users = $users->whereNotIn('users.id', $adminUsers);
        }

        if ($pagination) {
            return $users->paginate(15);
        } else {
            return $users->get();
        }

    }

    public static function getUser(int $userId)
    {
        return User::select('users.id', 'users.name', 'email', 'users.username', 'photo', 'mobile', 'authentication_log.login_at', 'email_verified_at')
            ->leftJoin('authentication_log', 'users.id', '=', 'authentication_log.authenticatable_id')
            ->where('users.id', $userId)
            ->orderBy('authentication_log.id', 'DESC')
            ->first();
    }

    public static function getUserByEmail(string $email)
    {
        return User::select('users.*')
            ->where('email', $email)
            ->first();
    }

    public static function addUser(array $userData)
    {
        $username = str_replace('--', '-', strtolower(
            preg_replace('/[^\da-zA-Z_]/i', '-',
                !empty($userData['username']) ? $userData['username'] : $userData['firstname']
            )));

        if (User::where('name', $username)->exists()) {
            $cu = User::where('name', 'like', '%' . $username . '%')->count() + 1;
            $username = "$username$cu";
        }

        $result = [
            'success' => false,
            'message' => '',
        ];

        try {

            $user = User::create([
                'name' => $userData['fullname'],
                'username' => $username,
                'email' => $userData['email'],
                'mobile' => $userData['mobile'],
                'password' => Hash::make($userData['password']),
            ]);
            $user->attachRole('teacher');


            $result['success'] = true;
            $result['user'] = $user;

            // Notification::newNotification($user->id, 'Welcome to Somriddhi');

        } catch (QueryException $ex) {
            $result['message'] = $ex->getMessage();
        }

        return $result;
    }
}
