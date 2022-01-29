<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Module\Dashboard\Controllers\AdminDashboard;
use App\Module\Dashboard\Controllers\TeacherDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(no_role()) {
            Auth::logout();

            return redirect()->route('login');
        }

        return has_role(auth()->user(), 'admin|superadmin') ? $this->adminDashboard($request) : $this->userDashboard($request);
    }

    protected function adminDashboard(Request $request) {
        return AdminDashboard::instance()->get($request);
    }

    protected function userDashboard(Request $request) {
        return TeacherDashboard::instance()->get($request);
    }
}
