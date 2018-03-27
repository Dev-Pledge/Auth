<?php

namespace DevPledge\Integrations\ServiceProvider;

use DevPledge\Integrations\Container\AbstractContainerCallable;

/**
 * Class AbstractService
 * @package DevPledge\Integrations\ServiceProvider
 */
abstract class AbstractService extends AbstractContainerCallable {
	/**
	 * usually return static::getFromContainer();
	 * @return mixed
	 */
	abstract static public function getService();
}