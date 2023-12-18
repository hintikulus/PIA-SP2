<?php

namespace Tests\Cases\Unit\Domain\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Location\Location;
use App\Domain\Stand\Stand;
use Contributte\Tester\TestCase\BaseTestCase;
use Tester\Assert;
use Tester\TestCase;

$container = require __DIR__ . '/../../../../bootstrap.php';
class BikeTest extends TestCase
{
    public function testTrue()
    {

        Assert::true(true);
    }
}

(new BikeTest())->run();
