<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(no_role()) {
            Auth::logout();

            return redirect()->route('login');
        }

        return has_role(auth()->user(), 'admin|superadmin') ? $this->adminDashboard() : $this->userDashboard();

        // return view('user.index', $viewParams);
    }

    protected function adminDashboard() {
        return [];
    }

    protected function userDashboard() {
        return [];
    }
}
