<?php

namespace App\Classes\Base\Database;

use Illuminate\Database\Eloquent\Relations\MorphPivot as IlluminateMorphPivot;

use App\Traits\Eloquent\ModelExtraMethods;

class MorphPivot extends IlluminateMorphPivot
{
    use ModelExtraMethods;

    public $incrementing = true;
}
