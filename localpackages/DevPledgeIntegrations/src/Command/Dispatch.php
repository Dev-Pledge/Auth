<?php


namespace DevPledge\Integrations\Command;


use DevPledge\Integrations\Event\AbstractEvent;
use DevPledge\Integrations\ServiceProvider\Services\CommandBusService;
use DevPledge\Integrations\ServiceProvider\Services\EventBusService;

/**
 * Class Dispatch
 * @package DevPledge\Integrations\Command
 */
class Dispatch {
	/**
	 * @param AbstractCommand $command
	 *
	 * @throws CommandException
	 */
	static public function command( AbstractCommand $command ) {
		CommandBusService::getService()->handle( $command );
	}

	/**
	 * @param AbstractEvent $event
	 */
	static public function event( AbstractEvent $event ) {
		EventBusService::getService()->handle( $event );
	}

}