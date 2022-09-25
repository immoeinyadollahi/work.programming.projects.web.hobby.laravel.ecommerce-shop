<?php

namespace App\Database\Seeders;



use App\Classes\Base\Database\Seeder;
use App\Database\Models\Role as RoleModel;

class Roles extends Seeder
{
    public function run()
    {
        $roles = [["name" => "user", "fa" => "کاربر"], ["name" => "admin", "fa" => "مدیر"]];
        foreach ($roles as $role) {
            RoleModel::create($role);
        }
    }
}
