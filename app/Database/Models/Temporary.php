<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class Temporary extends Model
{
    protected $table = 'temporaries';
    protected $casts = ["data" => "array"];
}
