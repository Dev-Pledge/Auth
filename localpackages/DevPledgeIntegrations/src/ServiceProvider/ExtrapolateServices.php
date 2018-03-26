<?php

namespace DevPledge\Integrations\ServiceProvider;


use DevPledge\Integrations\Container\AbstractContainerCallable;
use DevPledge\Integrations\Extrapolate\AbstractExtrapolate;

/**
 * Class ExtrapolateServices
 * @package DevPledge\Integrations\ServiceProvider
 */
class ExtrapolateServices extends AbstractExtrapolate {
	/**
	 * @param AbstractContainerCallable $callable
	 */
	protected function add( AbstractContainerCallable $callable ) {
		AddService::service( $callable );
	}
}