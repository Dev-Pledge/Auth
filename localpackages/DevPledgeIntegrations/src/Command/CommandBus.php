<?php

namespace DevPledge\Integrations\Command;

use PHPUnit\Runner\Exception;
use Slim\Container;

/**
 * Class CommandBus
 * @package DevPledge\Integrations\Command
 */
class CommandBus {

	protected $commandHandlerMap = [];


	/**
	 * @param AbstractCommand $command
	 *
	 * @throws CommandException
	 */
	public function handle( AbstractCommand $command ) {

		$handlerClass = $this->getHandler( get_class( $command ) );
		if ( $handlerClass ) {
			$handler = new $handlerClass();
			call_user_func_array( $handler, array( $command ) );
		} else {
			throw new CommandException( 'No command found for ' . get_class( $command ) );
		}
	}

	/**
	 * @param $key
	 *
	 * @return AbstractCommandHandler|null
	 */
	protected function getHandler( $key ): ?AbstractCommandHandler {
		if ( isset( $this->commandHandlerMap[ $key ] ) ) {
			return $this->commandHandlerMap[ $key ];
		}

		return null;
	}

	/**
	 * @param AbstractCommandHandler $commandHandler
	 *
	 * @return $this
	 */
	public function setHandler( AbstractCommandHandler $commandHandler ) {
		$this->commandHandlerMap[ $commandHandler->getContainerKey() ] = $commandHandler;

		return $this;
	}


}