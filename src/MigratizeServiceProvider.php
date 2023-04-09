<?php

namespace Smousss\Laravel\Migratize;

use Spatie\LaravelPackageTools\Package;
use Smousss\Laravel\Migratize\Commands\MigratizeCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MigratizeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package) : void
    {
        $package
            ->name('migratize')
            ->hasConfigFile()
            ->hasCommand(MigratizeCommand::class);
    }
}
