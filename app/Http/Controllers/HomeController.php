<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            return redirect('/dashboard');
        } else {
            return view('home', []);
        }
    }

    public function loginRedirect()
    {
        return $this->index();
    }
}
