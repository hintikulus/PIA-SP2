<?php

namespace Tests\Cases\Unit\Domain\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Location\Location;
use App\Domain\Stand\Stand;
use Contributte\Tester\TestCase\BaseTestCase;
use DateTime;
use Tester\Assert;
use Tester\TestCase;

$container = require __DIR__ . '/../../../../bootstrap.php';
class BikeTest extends TestCase
{
    private Bike $bike;
    public function setUp(): void
    {
        $this->bike = new Bike(new Location("1", "1"));
    }

    public function testTrue()
    {
        Assert::true(true);
    }

    public function testIsDueForService1()
    {
        $dateInterval = new \DateInterval("P30D");
        $lastServiceDatetime = (new DateTime())->sub(new \DateInterval("P31D"));
        $this->bike->setLastServiceTimestamp($lastServiceDatetime);

        Assert::true($this->bike->isDueForService($dateInterval));
    }

    public function testIsDueForService2()
    {
        $dateInterval = new \DateInterval("P60D");
        $lastServiceDatetime = (new DateTime())->sub(new \DateInterval("P31D"));
        $this->bike->setLastServiceTimestamp($lastServiceDatetime);

        Assert::false($this->bike->isDueForService($dateInterval));
    }

}

(new BikeTest())->run();
