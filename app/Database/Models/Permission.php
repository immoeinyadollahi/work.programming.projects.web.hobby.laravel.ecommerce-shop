<?php

namespace App\Database\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission as SpatiePermission;

use App\Traits\Eloquent\ModelExtraMethods;

class Permission extends SpatiePermission
{
    use ModelExtraMethods;

    public function roles(): BelongsToMany
    {
        return parent::roles()->withTimestamps();
    }
    public function users(): BelongsToMany
    {
        return parent::users()->withTimestamps();
    }
}
