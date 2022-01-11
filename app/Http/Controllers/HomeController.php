<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', []);
    }

    public function appHome($subdomain = null)
    {
        if(Auth::check()) {
            $domain = auth()->user()->domain;

            return redirect()->away(get_protocol() . "$domain." . config('app.short_url'));
        }
        return redirect('login');
    }

    public function userhome($subdomain = null)
    {
        dd('owner1123');
    }

    public function loginRedirect()
    {
        return $this->index();
    }
}
