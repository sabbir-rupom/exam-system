<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * View list of specific User type
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {

        $users = User::getUsers(($request->download ? false : true), $request);

        if ($request->download) {
            $this->_downloadUsers($users);
        }

        $request->flash();

        return view('owner.user-list', [
            'users' => $users,
        ]);

    }
}
