<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;
use App\Model\Database\QueryBuilderManager;
use App\Model\Database\QueryManager;
use Tracy\Debugger;
use Tracy\ILogger;

class DefaultStandService implements StandService
{
    private StandManager $standManager;
    private QueryBuilderManager $queryBuilderManager;
    private QueryManager $queryManager;

    public function __construct(
        StandManager        $standManager,
        QueryBuilderManager $queryBuilderManager,
        QueryManager        $queryManager,
    )
    {
        $this->standManager = $standManager;
        $this->queryBuilderManager = $queryBuilderManager;
        $this->queryManager = $queryManager;
    }

    public function getById(string $id): Stand
    {
        Debugger::log("Getting stand by id $id", ILogger::INFO);
        return $this->standManager->getById($id);
    }

    public function getAll(): array
    {
        Debugger::log('Getting all stands', ILogger::INFO);
        return $this->queryManager->findAll(StandQuery::getAll());
    }

    public function getAllDataSource(): mixed
    {
        Debugger::log('Getting all stands data source', ILogger::INFO);
        return $this->queryBuilderManager->getQueryBuilder(StandQuery::getAll());
    }

    public function createStand(string $name, Location $location): Stand
    {
        Debugger::log("Creating new stand $name at $location", ILogger::INFO);
        $stand = $this->standManager->createStand($name, $location);

        Debugger::log("Stand $stand created, saving it", ILogger::DEBUG);
        $this->standManager->save($stand);

        return $stand;
    }

    public function updateStand(Stand $stand, string $name, Location $location): void
    {
        Debugger::log("Updating stand $stand with $name at $location", ILogger::INFO);
        $this->standManager->updateStand($stand, $name, $location);

        Debugger::log("Stand $stand updated, saving it", ILogger::DEBUG);
        $this->standManager->save($stand);
    }
}