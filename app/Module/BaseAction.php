<?php

namespace App\Module;

use App\Traits\AppResponse;
use App\Http\Controllers\Controller;

class BaseAction extends Controller
{
    use AppResponse;

    public static function instance() {
        return new static;
    }

    protected function action()
    {
        return $this->response();
    }
}
