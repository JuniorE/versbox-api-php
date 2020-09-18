<?php

namespace JuniorE\Versbox\Tests;

use Orchestra\Testbench\TestCase;
use JuniorE\Versbox\VersboxServiceProvider;

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
