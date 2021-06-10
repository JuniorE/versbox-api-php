<?php

namespace JuniorE\Versbox\Endpoints\Tests;

use Orchestra\Testbench\TestCase;
use JuniorE\Versbox\Endpoints\VersboxServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [VersboxServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
