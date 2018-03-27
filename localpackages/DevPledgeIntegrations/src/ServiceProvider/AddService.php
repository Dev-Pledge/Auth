<?php

namespace DevPledge\Integrations\ServiceProvider;

use DevPledge\Integrations\Container\AddCallable;

/**
 * Class AddService
 * @package DevPledge\Integrations\ServiceProvider
 */
class AddService extends AddCallable {

	/**
	 * @param AbstractService $service
	 */
	public static function service( AbstractService $service ) {
		static::callable( $service );

	}

	/**
	 * @param AbstractService $service
	 *
	 * @return $this
	 */
	public function addService( AbstractService $service ) {
		static::service( $service );

		return $this;
	}


}