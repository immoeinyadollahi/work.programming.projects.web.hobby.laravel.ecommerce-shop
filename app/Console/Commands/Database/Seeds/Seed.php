<?php

namespace App\Console\Commands\Database\Seeds;

use Illuminate\Database\Console\Seeds\SeedCommand;

class Seed extends SeedCommand
{
    protected function getSeeder()
    {

        if ($class = $this->input->getArgument('class')) {
            if (!str_contains($class, '\\')) {
                $class = 'App\\Database\\Seeders\\' . $class;
            }
        } else {
            $class = 'App\\Database\\Seeders\\Database';
        }
        $this->input->setArgument("class", $class);
        return parent::getSeeder();
    }
}
