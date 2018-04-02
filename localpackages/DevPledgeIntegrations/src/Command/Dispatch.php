<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 31/03/2018
 * Time: 12:05
 */

namespace DevPledge\Integrations\Command;


use DevPledge\Integrations\ServiceProvider\Services\CommandBusService;

/**
 * Class Dispatch
 * @package DevPledge\Integrations\Command
 */
class Dispatch {
	/**
	 * @param AbstractCommand $command
	 *
	 * @throws \Interop\Container\Exception\ContainerException
	 */
	static public function command( AbstractCommand $command ) {
		CommandBusService::getService()->handle( $command );
	}
}