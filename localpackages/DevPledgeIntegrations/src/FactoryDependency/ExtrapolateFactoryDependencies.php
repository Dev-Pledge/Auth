<?php

namespace DevPledge\Integrations\FactoryDependency;

use DevPledge\Integrations\Container\AbstractContainerCallable;
use DevPledge\Integrations\Extrapolate\AbstractExtrapolate;

/**
 * Class ExtrapolateFactoryDependencies
 * @package DevPledge\Integrations\FactoryDependency
 */
class ExtrapolateFactoryDependencies extends AbstractExtrapolate {
	/**
	 * @param AbstractContainerCallable $callable
	 */
	protected function add( AbstractContainerCallable $callable ) {
		AddFactoryDependency::dependency( $callable );
	}

}