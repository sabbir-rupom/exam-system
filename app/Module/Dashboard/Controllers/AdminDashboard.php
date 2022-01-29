<?php

namespace App\Module\Dashboard\Controllers;

use App\Traits\AppResponse;
use Illuminate\Http\Request;

class AdminDashboard
{
    use AppResponse;

    public function init(Request $request) {
        return $this;
    }


    private function action()
    {
        return $this->response();
    }
}
