<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if(auth()->user()) {
            return $this->userHome();
        } else {
            return view('home', []);
        }
    }

    private function userHome(){
        if(has_role(auth()->user(), 'admin')) {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/dashboard');
        }
    }

    public function loginRedirect()
    {
        return $this->index();
    }
}
