<?php

namespace DevPledge\Framework\RouteGroups;


use DevPledge\Integrations\Route\AbstractRouteGroup;

/**
 * Class SwooleRouteGroup
 * @package DevPledge\Framework\RouteGroups
 */
class SwooleRouteGroup extends AbstractRouteGroup {

	public function __construct() {
		parent::__construct( '/swooletest' );
	}

	protected function setRoutesOnGroup() {
		$this->getApp()->get( '', function () use ( $app ) {

			shell_exec( 'php /var/www/swooletest.php > /dev/null 2>/dev/null &' );

		} );
	}
}