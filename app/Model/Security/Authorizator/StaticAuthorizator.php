<?php declare(strict_types = 1);

namespace App\Model\Security\Authorizator;

use App\Domain\User\User;
use Nette\Security\Permission;

final class StaticAuthorizator extends Permission
{

	/**
	 * Create ACL
	 */
	public function __construct()
	{
		$this->addRoles();
		$this->addResources();
		$this->addPermissions();
	}

	/**
	 * Setup roles
	 */
	protected function addRoles(): void
	{
		$this->addRole('guest');
        $this->addRole(User::ROLE_REGULAR, 'guest');
        $this->addRole(User::ROLE_SERVICEMAN, User::ROLE_REGULAR);
        $this->addRole(User::ROLE_ADMIN, User::ROLE_SERVICEMAN);
	}

	/**
	 * Setup resources
	 */
	protected function addResources(): void
	{
        $this->addResource('Regular');

        $this->addResource('Admin:Home', 'Regular');
        $this->addResource('Admin:Home:default', 'Admin:Home');

        $this->addResource('Admin:UserSettings', 'Regular');
        $this->addResource('Admin:UserSettings:default', 'Admin:UserSettings');

        $this->addResource('Admin:MyRides', 'Regular');
        $this->addResource('Admin:MyRides:default', 'Admin:MyRides');

        $this->addResource('Service');


        $this->addResource('Administration');

        $this->addResource('Admin:User', 'Administration');
        $this->addResource('Admin:User:list', 'Admin:User');
        $this->addResource('Admin:User:add', 'Admin:User');
        $this->addResource('Admin:User:edit', 'Admin:User');

        $this->addResource('Admin:Stand', 'Administration');
        $this->addResource('Admin:Stand:list', 'Admin:Stand');
        $this->addResource('Admin:Stand:add', 'Admin:Stand');
        $this->addResource('Admin:Stand:edit', 'Admin:Stand');

        $this->addResource('Admin:Bike', 'Administration');
        $this->addResource('Admin:Bike:list', 'Admin:Bike');
        $this->addResource('Admin:Bike:add', 'Admin:Bike');
        $this->addResource('Admin:Bike:edit', 'Admin:Bike');
        $this->addResource('Admin:Bike:dueForService', 'Admin:Bike');
        $this->addResource('Admin:Bike:service', 'Admin:Bike');

        $this->addResource('Admin:Ride', 'Administration');
        $this->addResource('Admin:Ride:detail', 'Admin:Ride');
        $this->addResource('Admin:Ride:start', 'Admin:Ride');

    }

	/**
	 * Setup ACL
	 */
	protected function addPermissions(): void
	{
        $this->allow(User::ROLE_REGULAR, 'Regular');
        $this->allow(User::ROLE_SERVICEMAN, 'Service');
        $this->allow(User::ROLE_ADMIN, 'Administration');
	}

}
