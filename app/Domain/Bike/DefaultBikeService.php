<?php

namespace App\Domain\Bike;

use App\Domain\Location\Location;
use App\Domain\Stand\StandManager;
use App\Model\App;
use App\Model\Database\QueryBuilderManager;
use App\Model\Database\QueryManager;
use App\Model\Exception\Logic\BikeNotServiceableException;
use App\Model\Exception\Logic\StandNotFoundException;
use Ramsey\Uuid\Uuid;
use Tracy\Debugger;
use Tracy\ILogger;

class DefaultBikeService implements BikeService
{
    private BikeManager $bikeManager;
    private StandManager $standManager;
    private QueryManager $queryManager;
    private QueryBuilderManager $queryBuilderManager;

    public function __construct(
        BikeManager $bikeManager,
        StandManager $standManager,
        QueryManager $queryManager,
        QueryBuilderManager $queryBuilderManager,
    )
    {
        $this->bikeManager = $bikeManager;
        $this->standManager = $standManager;
        $this->queryManager = $queryManager;
        $this->queryBuilderManager = $queryBuilderManager;
    }

    public function getById(string $id): Bike
    {
        Debugger::getLogger()->log("Getting Bike by id {$id}", ILogger::INFO);
        return $this->bikeManager->getById($id);
    }

    public function getAllBikes(): array
    {
        Debugger::getLogger()->log('Getting all bikes', ILogger::INFO);
        return $this->queryManager->findAll(BikeQuery::getAll());
    }

    public function getAllBikesDataSource(): mixed
    {
        Debugger::getLogger('Getting all bikes data source', ILogger::INFO);
        return $this->queryBuilderManager->getQueryBuilder(BikeQuery::getAll());
    }

    public function getRideableBikes(): array
    {
        Debugger::log('Getting rideable bikes', ILogger::INFO);
        return $this->queryManager->findAll(BikeQuery::getRideable());
    }

    public function getBikesDueForService(): array
    {
        Debugger::getLogger()->log('Getting bikes due for service', ILogger::INFO);
        return $this->queryManager->findAll(BikeQuery::getDueForService());
    }

    public function getBikesDueForServiceDataSource(): mixed
    {
        Debugger::getLogger()->log('Getting bikes due for service data source', ILogger::INFO);
        return $this->queryBuilderManager->getQueryBuilder(BikeQuery::getDueForService());
    }

    public function markServiced(Bike $bike): void
    {
        Debugger::getLogger()->log("Marking bike $bike services", ILogger::INFO);

        if(!$bike->isDueForService())
        {
            throw new BikeNotServiceableException($bike);
        }

        $bike->updateLastServiceTimestamp();

        Debugger::getLogger()->log("Bike $bike is mark serviced, saving it", ILogger::DEBUG);

        $this->bikeManager->save($bike);
    }

    public function moveBike(Bike $bike, Location $location): void
    {
        Debugger::getLogger()->log("Changing position of bike $bike to location $location", ILogger::INFO);
        $bike->setLocation($location);

        Debugger::getLogger()->log("Bike $bike changed location to $location, saving it", ILogger::DEBUG);
        $this->bikeManager->save($bike);

        // TODO: websocket send bike move information
    }

    public function createBike(string $standId): Bike
    {
        Debugger::getLogger()->log("Creating new bike in stand $standId", ILogger::INFO);
        $stand = $this->standManager->getById($standId);
        $bike = $this->bikeManager->createBike($stand);

        Debugger::getLogger()->log("Bike $bike created, saving it", ILogger::DEBUG);
        $this->bikeManager->save($bike);

        return $bike;
    }

    public function updateBike(Bike $bike, ?string $standId, \DateTime $lastServiceDatetime): void
    {
        Debugger::getLogger()->log("Updating bike {$bike} data", ILogger::INFO);
        $stand = $this->standManager->findById($standId);

        $this->bikeManager->updateBike($bike, $stand, $lastServiceDatetime);

        Debugger::getLogger()->log("Bike $bike updated, saving it", ILogger::DEBUG);
        $this->bikeManager->save($bike);
    }
}