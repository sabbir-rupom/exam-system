<?php

namespace App\Module\Dashboard\Controllers;

use App\Module\BaseAction;
use Illuminate\Http\Request;
class AdminDashboard extends BaseAction
{
    public function get(Request $request) {
        return $this->init($request)->action();
    }

    private function init(Request $request) {
        $this->setView('module.dashboard.admin');
        return $this;
    }

}
