<?php

namespace App\Classes\Base\Database;

use Illuminate\Database\Eloquent\Relations\Pivot as IlluminatePivot;

use App\Traits\Eloquent\ModelExtraMethods;

class Pivot extends IlluminatePivot
{
    use ModelExtraMethods;

    public $incrementing = true;
}
