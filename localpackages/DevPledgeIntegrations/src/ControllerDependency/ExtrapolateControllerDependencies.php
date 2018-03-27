<?php

namespace DevPledge\Integrations\ControllerDependency;


use DevPledge\Integrations\Container\AbstractContainerCallable;
use DevPledge\Integrations\Extrapolate\AbstractExtrapolate;

/**
 * Class ExtrapolateControllerDependencies
 * @package DevPledge\Integrations\ControllerDependency
 */
class ExtrapolateControllerDependencies extends AbstractExtrapolate {
	/**
	 * @param AbstractContainerCallable $callable
	 */
	protected function add( AbstractContainerCallable $callable ) {
		AddControllerDependency::dependency( $callable );
	}

}