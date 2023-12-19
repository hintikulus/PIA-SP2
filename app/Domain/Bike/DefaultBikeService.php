<?php

namespace App\Domain\Bike;

use App\Domain\Config\ConfigService;
use App\Domain\Location\Location;
use App\Domain\Ride\Ride;
use App\Domain\Ride\RideUpdateNotifyManager;
use App\Domain\Stand\StandManager;
use App\Model\App;
use App\Model\Database\QueryBuilderManager;
use App\Model\Database\QueryManager;
use App\Model\Exception\Logic\BikeNotServiceableException;
use App\Model\Exception\Logic\StandNotFoundException;
use Contributte\Monolog\LoggerManager;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Tracy\Debugger;
use Tracy\ILogger;

class DefaultBikeService implements BikeService
{
    private BikeManager $bikeManager;
    private StandManager $standManager;
    private QueryManager $queryManager;
    private QueryBuilderManager $queryBuilderManager;
    private RideUpdateNotifyManager $rideUpdateNotifyManager;
    private ConfigService $configService;
    private LoggerInterface $logger;

    public function __construct(
        BikeManager $bikeManager,
        StandManager $standManager,
        QueryManager $queryManager,
        QueryBuilderManager $queryBuilderManager,
        RideUpdateNotifyManager $rideUpdateNotifyManager,
        ConfigService $configService,
        LoggerInterface $logger,
    )
    {
        $this->bikeManager = $bikeManager;
        $this->standManager = $standManager;
        $this->queryManager = $queryManager;
        $this->queryBuilderManager = $queryBuilderManager;
        $this->rideUpdateNotifyManager = $rideUpdateNotifyManager;
        $this->configService = $configService;
        $this->logger = $logger;
    }

    public function getById(string $id): Bike
    {
        $this->logger->info("Getting Bike by id {$id}");
        return $this->bikeManager->getById($id);
    }

    public function getAllBikes(): array
    {
        $this->logger->info('Getting all bikes');
        return $this->queryManager->findAll(BikeQuery::getAll());
    }

    public function getAllBikesDataSource(): mixed
    {
        $this->logger->info('Getting all bikes data source');
        return $this->queryBuilderManager->getQueryBuilder(BikeQuery::getAll());
    }

    public function getRideableBikes(): array
    {
        $this->logger->info('Getting rideable bikes');
        return $this->queryManager->findAll(BikeQuery::getRideable());
    }

    public function getBikesDueForService(): array
    {
        $this->logger->info('Getting bikes due for service');
        return $this->queryManager->findAll(BikeQuery::getDueForService());
    }

    public function getBikesDueForServiceDataSource(): mixed
    {
        $this->logger->info('Getting bikes due for service data source');
        return $this->queryBuilderManager->getQueryBuilder(BikeQuery::getDueForService());
    }

    public function markServiced(Bike $bike): void
    {
        $this->logger->info("Marking bike $bike services");

        if(!$bike->isDueForService($this->configService->getBikeServiceInterval()))
        {
            throw new BikeNotServiceableException($bike);
        }

        $bike->updateLastServiceTimestamp();

        $this->logger->debug("Bike $bike is mark serviced, saving it");

        $this->bikeManager->save($bike);
    }

    public function moveBikeInRide(Ride $ride, Location $location): void
    {

        $this->logger->info("Changing position of bike to location $location");
        $bike = $ride->getBike();
        $bike->setLocation($location);

        $this->logger->debug("Bike $bike changed location to $location, saving it");

        $this->bikeManager->save($bike);

        $this->logger->debug("Bike $bike saved location update, notifying it");
        $this->rideUpdateNotifyManager->notifyRideBikeLocationUpdate($ride, $location);
    }

    public function createBike(string $standId): Bike
    {
        $this->logger->info("Creating new bike in stand $standId");
        $stand = $this->standManager->getById($standId);
        $bike = $this->bikeManager->createBike($stand);

        $this->logger->debug("Bike $bike created, saving it");
        $this->bikeManager->save($bike);

        return $bike;
    }

    public function updateBike(Bike $bike, ?string $standId, \DateTime $lastServiceDatetime): void
    {
        $this->logger->info("Updating bike {$bike} data");
        $stand = $this->standManager->findById($standId);

        $this->bikeManager->updateBike($bike, $stand, $lastServiceDatetime);

        $this->logger->debug("Bike $bike updated, saving it");
        $this->bikeManager->save($bike);
    }
}
