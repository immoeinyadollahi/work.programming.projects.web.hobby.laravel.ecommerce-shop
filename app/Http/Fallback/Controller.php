<?php

namespace App\Http\Fallback;

use App\Classes\Base\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __invoke()
    {
        _http_abort(404);
    }
}
