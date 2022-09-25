<?php

namespace App\Traits\Spatie;

use Spatie\Permission\Traits\HasPermissions as SpatieHasPermissions;

trait HasPermissions
{
    use SpatieHasPermissions {
        SpatieHasPermissions::permissions as spatiePermissions;
    }
    public function permissions()
    {
        return $this->spatiePermissions()->withTimestamps();
    }
}
