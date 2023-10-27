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
        $this->addRole('regular', 'guest');
        $this->addRole('service_man', 'regular');
        $this->addRole('authenticated', 'regular');
	}

	/**
	 * Setup resources
	 */
	protected function addResources(): void
	{
		$this->addResource('Admin:Home');
	}

	/**
	 * Setup ACL
	 */
	protected function addPermissions(): void
	{
        $this->allow(self::ALL, self::ALL);

		$this->allow(['authenticated'], [
			'Admin:Home',
		]);
	}

}
