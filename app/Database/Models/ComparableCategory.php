<?php

namespace App\Database\Models;

use App\Classes\Base\Database\Model;

/* 
    source and target of two comparable categories are not important and only association between two categories are important so don't specify which category can be compared with another category
    and only determine two category can be compared with each other
*/

class ComparableCategory extends Model
{
    protected $table = 'comparable_categories';
}
