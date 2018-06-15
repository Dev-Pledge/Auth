<?php

namespace DevPledge\Framework\RouteGroups;


use DevPledge\Framework\Controller\User\UserCreateController;
use DevPledge\Integrations\Route\AbstractRouteGroup;

/**
 * Class UserRouteGroup
 * @package DevPledge\Framework\RouteGroups
 */
class UserRouteGroup extends AbstractRouteGroup {
	public function __construct() {
		parent::__construct( '/user' );
	}

	protected function callableInGroup() {
		$this->getApp()->post(
			'/createFromUsernamePassword',
			UserCreateController::class . ':createUserFromUsernamePassword'
		);
		$this->getApp()->post(
			'/createFromGitHub',
			UserCreateController::class . ':createUserFromGitHub'
		);
	}
}