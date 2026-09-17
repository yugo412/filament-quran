<?php

namespace Yugo\FilamentQuran\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Yugo\FilamentQuran\FilamentQuranServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            FilamentQuranServiceProvider::class,
        ];
    }
}
