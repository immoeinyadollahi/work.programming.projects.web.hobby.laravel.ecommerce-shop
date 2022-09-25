<?php

namespace App\Database\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

use App\Traits\Eloquent\ModelExtraMethods;

class Role extends SpatieRole
{
    use ModelExtraMethods;

    public function permissions(): BelongsToMany
    {
        return parent::permissions()->withTimestamps();
    }
    public function users(): BelongsToMany
    {
        return parent::users()->withTimestamps();
    }
}
