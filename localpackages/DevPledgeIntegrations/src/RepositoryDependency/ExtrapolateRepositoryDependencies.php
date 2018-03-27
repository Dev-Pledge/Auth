<?php

namespace DevPledge\Integrations\RepositoryDependency;

use DevPledge\Integrations\Container\AbstractContainerCallable;
use DevPledge\Integrations\Extrapolate\AbstractExtrapolate;

/**
 * Class ExtrapolateRepositoryDependencies
 * @package DevPledge\Integrations\RepositoryDependency
 */
class ExtrapolateRepositoryDependencies extends AbstractExtrapolate {
	/**
	 * @param AbstractContainerCallable $callable
	 */
	protected function add( AbstractContainerCallable $callable ) {
		AddRepositoryDependency::dependency( $callable );
	}

}