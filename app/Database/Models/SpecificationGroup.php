<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

class SpecificationGroup extends Model
{
    protected $table = 'specification_groups';

    public function specifications()
    {
        return $this->hasMany(Specification::class, "group_id");
    }
}
