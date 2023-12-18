<?php

namespace Tests\Cases\Integration\Domain\Bike;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeManager;
use App\Domain\Bike\BikeRepository;
use App\Domain\Bike\BikeService;
use App\Domain\Bike\DefaultBikeService;
use App\Domain\Location\Location;
use App\Domain\Ride\RideUpdateNotifyManager;
use App\Domain\Stand\Stand;
use App\Domain\Stand\StandManager;
use App\Model\App;
use App\Model\Database\QueryBuilderManager;
use App\Model\Database\QueryManager;
use App\Model\Exception\Logic\BikeNotFoundException;
use App\Model\Exception\Logic\BikeNotServiceableException;
use Contributte\Tester\TestCase\BaseTestCase;
use Psr\Log\LoggerInterface;
use Tester\Assert;


$container = require __DIR__ . '/../../../../bootstrap.php';

class DefaultBikeServiceTest extends BaseTestCase
{
    private BikeManager $bikeManager;
    private StandManager $standManager;
    private QueryManager $queryManager;
    private QueryBuilderManager $queryBuilderManager;
    private RideUpdateNotifyManager $rideUpdateNotifyManager;
    private LoggerInterface $loggerInterface;

    private BikeService $bikeService;

    public function setUp()
    {
        $this->bikeManager = \Mockery::mock(BikeManager::class);
        $this->standManager = \Mockery::mock(StandManager::class);
        $this->queryManager = \Mockery::mock(QueryManager::class);
        $this->queryBuilderManager = \Mockery::mock(QueryBuilderManager::class);
        $this->rideUpdateNotifyManager = \Mockery::mock(RideUpdateNotifyManager::class);
        $this->loggerInterface = \Mockery::mock(LoggerInterface::class)->allows([
            'info' => null,
            'debug' => null,
        ]);


        $this->bikeService = new DefaultBikeService(
            $this->bikeManager,
            $this->standManager,
            $this->queryManager,
            $this->queryBuilderManager,
            $this->rideUpdateNotifyManager,
            $this->loggerInterface,
        );

        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testGetBike()
    {
        $stand = new Stand('test', new Location('5', '5'));
        $bike = new Bike($stand);
        $id = "123";

        $this->bikeManager
            ->allows('getById')
            ->with($id)
            ->andReturn($bike);

        Assert::equal($bike, $this->bikeService->getById($id));
    }

    public function testBikeNotFound()
    {
        $stand = new Stand('test', new Location('5', '5'));
        $bike = new Bike($stand);
        $id = "123";

        $this->bikeManager
            ->allows('getById')
            ->with($id)
            ->andThrow(BikeNotFoundException::class);

        Assert::throws(fn() => $this->bikeService->getById($id), BikeNotFoundException::class);
    }

    public function testMarkServiced(): void
    {
        $stand = new Stand('test', new Location('5', '5'));
        $bike = new Bike($stand);
        $bike->setLastServiceTimestamp($bike->getLastServiceTimestamp()->modify('-' . App::SERVICE_TIME));

        $this->bikeManager->shouldReceive('save')->once();
        $this->bikeManager->shouldReceive('save')->with($bike);

        $this->bikeService->markServiced($bike);

        Assert::false($bike->isDueForService());
    }

    public function testBikeNotServiceable(): void
    {
        $stand = new Stand('test', new Location('5', '5'));
        $bike = new Bike($stand);

        $this->bikeManager->shouldReceive('save')->once();
        $this->bikeManager->shouldReceive('save')->with($bike);

        Assert::throws(fn() => $this->bikeService->markServiced($bike), BikeNotServiceableException::class);
    }

}

(new DefaultBikeServiceTest())->run();
