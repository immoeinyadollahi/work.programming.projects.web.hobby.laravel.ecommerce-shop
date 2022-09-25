<?php

namespace App\Traits\Spatie;

use Spatie\Permission\Traits\HasRoles as SpatieHasRoles;

trait HasRoles
{
    use SpatieHasRoles {
        SpatieHasRoles::roles as spatieRoles;
    }
    public function roles()
    {
        return $this->spatieRoles()->withTimestamps();
    }
}
