<?php

namespace App\Actions\Fortify;

use App\Models\User;
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

        $userArray = [
            'email' => $input['email'],
            'password' => Hash::make($input['password'])
        ];

        try {
            $userArray['name'] = isset($input['name']) ? trim($input['name']) : (
                isset($input['firstname']) ? trim($input['firstname'] . (isset($input['lastname']) ? ' ' . $input['lastname'] : '')) : null
            );

            $userArray['phone'] = isset($input['phone']) ? $input['phone'] : null;

            $userArray['username'] = $this->_getUsername($input);

            $user = User::create($userArray);

            $user->attachRole('teacher');

            DB::commit();

            Session::flash('success', 'User registration successful');

            $user->email_verified_at = Carbon::now();
            $user->save();

        } catch (QueryException $ex) {
            DB::rollBack();
            Session::flash('status', $ex->getMessage());
            throw $ex;
        } catch (\Throwable $th) {
            DB::rollBack();
            Session::flash('status', $th->getMessage());
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

        if(isset($input['username'])) {
            $validationRules['username'] = ['required', 'string', 'max:100', Rule::unique(User::class)];
        }

        if(isset($input['firstname'])) {
            $validationRules['firstname'] = ['required', 'string', 'max:100'];
        }

        if(isset($input['phone'])) {
            $validationRules['phone'] = ['required', 'phone', Rule::unique(User::class)];
        }

        if(isset($input['lastname']) && !empty($input['lastname'])) {
            $validationRules['lastname'] = ['string', 'max:100'];
        }

        Validator::make($input, $validationRules)->validate();
    }

    /**
     * Validate and return unique username
     *
     * @param array $input
     * @return string
     */
    private function _getUsername(array $input) :string {
        $username = isset($input['username']) ? trim($input['username']) : '';

        if(empty($username)) {
            $username = explode('@', $input['email'])[0];
        }

        $temp = $username;

        while(User::where('username', $temp)->exists()) {
            $temp = $username . rand(1, 9999);
        }

        return $temp;
    }
}
