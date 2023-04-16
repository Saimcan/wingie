<?php

namespace App\Service;

use App\Factory\DeveloperFactory;

class DeveloperService
{
    public function generateDevelopers(): void
    {
        DeveloperFactory::createOne(['level' => 1]);
        DeveloperFactory::createOne(['level' => 2]);
        DeveloperFactory::createOne(['level' => 3]);
        DeveloperFactory::createOne(['level' => 4]);
        DeveloperFactory::createOne(['level' => 5]);
    }
}
