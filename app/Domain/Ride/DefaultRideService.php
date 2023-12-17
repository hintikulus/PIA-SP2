<?php

namespace App\Domain\Ride;

use App\Domain\Bike\Bike;
use App\Domain\Bike\BikeQuery;
use App\Domain\Stand\Stand;
use App\Domain\User\User;
use App\Model\App;
use App\Model\Database\QueryBuilderManager;
use App\Model\Database\QueryManager;
use App\Model\Exception\Logic\BikeTooFarFromEndStand;
use App\Model\Exception\Logic\UserInRideException;
use App\Model\Exception\Runtime\InvalidStateException;

class DefaultRideService implements RideService
{
    private RideManager $rideManager;
    private QueryManager $queryManager;
    private QueryBuilderManager $queryBuilderManager;

    public function __construct(
        RideManager         $rideManager,
        QueryManager        $queryManager,
        QueryBuilderManager $queryBuilderManager,
    )
    {
        $this->rideManager = $rideManager;
        $this->queryManager = $queryManager;
        $this->queryBuilderManager = $queryBuilderManager;
    }

    public function getById(string $id): Ride
    {
        return $this->rideManager->getById($id);
    }

    public function findById(string $id): ?Ride
    {
        return $this->rideManager->findById($id);
    }

    public function getUserRides(User $user): array
    {
        return $this->queryManager->findAll(RideQuery::getByUser($user));
    }

    public function getUserRidesDataSource(User $user): mixed
    {
        return $this->queryBuilderManager->getQueryBuilder(RideQuery::getByUser($user));
    }

    public function startRide(User $user, Bike $bike): Ride
    {
        if ($this->isUserInRide($user))
        {
            throw new UserInRideException($user);
        }

        $ride = $this->rideManager->startRide($user, $bike);

        $this->rideManager->save($ride);
        return $ride;
    }

    public function completeRide(Ride $ride, Stand $stand): void
    {
        if ($ride->getState() !== Ride::STATE_STARTED)
        {
            throw new InvalidStateException("Ride $ride curently is not started, it cannot be completed");
        }

        $distance = $ride->getBike()->getLocation()->distance($stand->getLocation());

        if ($distance > App::BIKE_DISTANCE_DELIVERY)
        {
            throw new BikeTooFarFromEndStand($ride->getBike(), $stand);
        }

        $ride->complete($stand);
        $this->rideManager->save($ride);
    }

    public function isUserInRide(User $user): bool
    {
        return $this->findUsersActiveRide($user) !== null;
    }

    public function findUsersActiveRide(User $user): ?Ride
    {
        return $this->rideManager->findActiveByUser($user);
    }
}