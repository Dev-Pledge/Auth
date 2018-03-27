<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 25/03/2018
 * Time: 21:06
 */

namespace DevPledge\Integrations;

/**
 * Class Sentry
 * @package DevPledge\Integrations
 */
class Sentry {
	/**
	 * @var \Raven_Client
	 */
	protected static $client;

	static public function setSentry( \Raven_Client $client ) {
		$error_handler = new \Raven_ErrorHandler( $client );
		$error_handler->registerExceptionHandler();
		$error_handler->registerErrorHandler();
		$error_handler->registerShutdownFunction();
		static::$client = $client;
	}

	/**
	 * @return \Raven_Client
	 */
	static public function get() {
		return static::$client;
	}
}