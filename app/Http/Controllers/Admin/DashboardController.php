<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yadahan\AuthenticationLog\AuthenticationLog;

class DashboardController extends Controller
{
    public function index()
    {

        $totalAdmins = array_column(User::select('users.id')->whereRoleIs('admin')
                ->orWhereRoleIs('superadmin')->groupBy('users.id')->get()->toArray(), 'id');

        $totalUser = User::whereNotIn('id', $totalAdmins)->whereNotNull('email_verified_at')->count();

        $activeUsers = AuthenticationLog::select('authenticatable_id')->whereBetween('login_at', [
            \carbon\Carbon::now()->subdays(3)->format('Y-m-d'),
            \carbon\Carbon::now()->adddays(1)->format('Y-m-d'),
        ])->whereNotIn('authenticatable_id', $totalAdmins)->groupBy('authenticatable_id')->get();


        return view('admin.index', [
            'total' => [
                'users' => $totalUser,
                'active_users' => $activeUsers->count(),
            ],
        ]);
    }
}
