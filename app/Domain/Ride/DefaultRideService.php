<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeQuery;
use App\Domain\Config\ConfigService;
use App\Domain\Stand\Stand;
use App\Domain\User\User;
use App\Model\App;
use App\Model\Database\QueryBuilderManager;
use App\Model\Database\QueryManager;
use App\Model\Exception\Logic\BikeTooFarFromEndStand;
use App\Model\Exception\Logic\UserInRideException;
use App\Model\Exception\Runtime\InvalidStateException;
use Psr\Log\LoggerInterface;

class DefaultRideService implements RideService
{
    private RideManager $rideManager;
    private QueryManager $queryManager;
    private QueryBuilderManager $queryBuilderManager;
    private ConfigService $configService;
    private LoggerInterface $logger;

    public function __construct(
        RideManager         $rideManager,
        QueryManager        $queryManager,
        QueryBuilderManager $queryBuilderManager,
        ConfigService $configService,
        LoggerInterface     $logger,
    )
    {
        $this->rideManager = $rideManager;
        $this->queryManager = $queryManager;
        $this->queryBuilderManager = $queryBuilderManager;
        $this->configService = $configService;
        $this->logger = $logger;
    }

    public function getById(string $id): Ride
    {
        $this->logger->info("Getting Ride by id {$id}");
        return $this->rideManager->getById($id);
    }

    public function findById(string $id): ?Ride
    {
        $this->logger->info("Finding Ride by id {$id}");
        return $this->rideManager->findById($id);
    }

    public function getUserRides(User $user): array
    {
        $this->logger->info("Getting user {$user} rides");
        return $this->queryManager->findAll(RideQuery::getByUser($user));
    }

    public function getUserRidesDataSource(User $user): mixed
    {
        $this->logger->info("Getting user {$user}, rides data source");
        return $this->queryBuilderManager->getQueryBuilder(RideQuery::getByUser($user));
    }

    public function startRide(User $user, Bike $bike): Ride
    {
        $this->logger->info("Starting a ride by $user on bike $bike");
        if ($this->isUserInRide($user))
        {
            throw new UserInRideException($user);
        }

        $ride = $this->rideManager->startRide($user, $bike, $this->configService->getBikeServiceInterval());

        $this->logger->debug("Ride $ride is started, saving it");

        $this->rideManager->save($ride);
        return $ride;
    }

    public function completeRide(Ride $ride, Stand $stand): void
    {
        $this->logger->info("Completing ride $ride on stand $stand");
        if ($ride->getState() !== Ride::STATE_STARTED)
        {
            throw new InvalidStateException("Ride $ride curently is not started, it cannot be completed");
        }

        $distance = $ride->getBike()->getLocation()->distance($stand->getLocation());

        if ($distance > App::BIKE_DISTANCE_DELIVERY)
        {
            throw new BikeTooFarFromEndStand($ride->getBike(), $stand);
        }

        $this->logger->debug("Ride $ride is completed, saving it");

        $ride->complete($stand);
        $this->rideManager->save($ride);
    }

    public function isUserInRide(User $user): bool
    {
        $this->logger->info("Detecting the user $user has an active ride");
        return $this->findUsersActiveRide($user) !== null;
    }

    public function findUsersActiveRide(User $user): ?Ride
    {
        $this->logger->info("Finding user's $user active ride");
        return $this->rideManager->findActiveByUser($user);
    }
}