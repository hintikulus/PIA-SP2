<?php

namespace App\Domain\Stand;

use App\Domain\Location\Location;
use App\Model\Database\QueryBuilderManager;
use App\Model\Database\QueryManager;
use Psr\Log\LoggerInterface;
use Tracy\Debugger;
use Tracy\ILogger;

class DefaultStandService implements StandService
{
    private StandManager $standManager;
    private QueryBuilderManager $queryBuilderManager;
    private QueryManager $queryManager;
    private LoggerInterface $logger;

    public function __construct(
        StandManager        $standManager,
        QueryBuilderManager $queryBuilderManager,
        QueryManager        $queryManager,
        LoggerInterface     $logger,
    )
    {
        $this->standManager = $standManager;
        $this->queryBuilderManager = $queryBuilderManager;
        $this->queryManager = $queryManager;
        $this->logger = $logger;
    }

    public function getById(string $id): Stand
    {
        $this->logger->info("Getting stand by id $id");
        return $this->standManager->getById($id);
    }

    public function getAll(): array
    {
        $this->logger->info('Getting all stands');
        return $this->queryManager->findAll(StandQuery::getAll());
    }

    public function getAllDataSource(): mixed
    {
        $this->logger->info('Getting all stands data source');
        return $this->queryBuilderManager->getQueryBuilder(StandQuery::getAll());
    }

    public function createStand(string $name, Location $location): Stand
    {
        $this->logger->info("Creating new stand $name at $location");
        $stand = $this->standManager->createStand($name, $location);

        $this->logger->debug("Stand $stand created, saving it");
        $this->standManager->save($stand);

        return $stand;
    }

    public function updateStand(Stand $stand, string $name, Location $location): void
    {
        $this->logger->info("Updating stand $stand with $name at $location");
        $this->standManager->updateStand($stand, $name, $location);

        $this->logger->debug("Stand $stand updated, saving it");
        $this->standManager->save($stand);
    }
}