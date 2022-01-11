<?php

namespace App\Actions\Fortify;

use App\Library\Notification\Email;
use App\Models\Organization;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserOwner;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $this->_validateRequest($input);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => trim($input['firstname'] . ' ' . $input['lastname']),
                'username' => $input['username'],
                'mobile' => $input['phone'],
                'email' => $input['email'],
                'password' => Hash::make($input['password'])
            ]);
            $user->attachRole('teacher');

            DB::commit();

            Session::flash('success', 'User registration successful');

            // $emailStatus = Email::getInstance()->initConfig([
            //     'receiver' => $user->email,
            //     'type' => 'new-user',
            //     'data' => [
            //         'fullname' => $input['firstname'] . ' ' . $input['lastname'],
            //         'url' => url('/user/activate') . '?data=' . \App\Actions\UserActivation::init($user),
            //         'username' => $user->email,
            //     ],
            // ])->send();
            // if ($emailStatus !== true) {
            //     Session::flash('status', 'Sorry! ' . (is_string($emailStatus) ? $emailStatus : 'Failed to send email for account activation'));
            //     Session::flash('mail-failure', 1);
            // }

            $user->email_verified_at = Carbon::now();
            $user->save();

        } catch (QueryException $ex) {
            DB::rollBack();
            Session::flash('status', $ex->getMessage());
            throw $ex;
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('status', $ex->getMessage());
            throw $th;
        }

        return $user;
    }

    /**
     * Validate registration post data
     *
     * @param array $input
     * @return void
     */
    private function _validateRequest(array $input)
    {
        $validationRules = [
            'username' => ['required', 'string', 'max:100', Rule::unique(User::class)],
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'min:5', 'confirmed'],
            'password_confirmation' => ['required', 'same:password'],
        ];

        $validationRules['phone'] = ['required', 'string', 'min:8', 'max:15'];

        Validator::make($input, $validationRules)->validate();
    }
}
