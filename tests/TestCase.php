<?php

namespace Smousss\Laravel\Migratize\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Smousss\Laravel\Migratize\MigratizeServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [MigratizeServiceProvider::class];
    }
}
