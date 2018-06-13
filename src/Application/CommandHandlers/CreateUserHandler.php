<?php

namespace DevPledge\Application\CommandHandlers;


use DevPledge\Application\Commands\CreateUserCommand;
use DevPledge\Integrations\Command\AbstractCommandHandler;

class CreateUserHandler extends AbstractCommandHandler {

	public function __construct() {
		parent::__construct( CreateUserCommand::class );
	}

	/**
	 * @param $command CreateUserCommand
	 */
	protected function handle( $command ) {
		$thirdPartyAuth = $command->getThirdPartyAuth();

		$thirdPartyAuth->validate();

	}
}