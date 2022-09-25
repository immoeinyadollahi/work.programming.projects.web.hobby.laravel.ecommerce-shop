<?php

namespace App\Classes\Base\Database;

use Illuminate\Database\Eloquent\Model as IlluminateModel;

use App\Traits\Eloquent\ModelExtraMethods;

class Model extends IlluminateModel
{
    use ModelExtraMethods;

    protected $guarded = [];
}
