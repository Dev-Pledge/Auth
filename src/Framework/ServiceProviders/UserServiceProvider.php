<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 12/06/2018
 * Time: 22:37
 */

namespace DevPledge\Framework\ServiceProviders;


use DevPledge\Integrations\ServiceProvider\AbstractServiceProvider;
use Slim\Container;

class UserServiceProvider extends AbstractServiceProvider {




	/**
	 * @param Container $container
	 *
	 * @return mixed
	 */
	public function __invoke( Container $container ) {
		// TODO: Implement __invoke() method.
	}

	/**
	 * usually return static::getFromContainer();
	 * @return mixed
	 */
	static public function getService() {
		// TODO: Implement getService() method.
	}
}