<?php

namespace NotitiaVisum\Test;

use NotitiaVisum\NotitiaVisum;
use NotitiaVisum\Provider\NotitiaVisumServiceProvider;
use Orchestra\Testbench\TestCase;

class NotitiaVisumTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [NotitiaVisumServiceProvider::class];
    }

    public function testInstance()
    {
        $nv = new NotitiaVisum();

        $this->assertInstanceOf(NotitiaVisum::class, $nv);
    }
}
