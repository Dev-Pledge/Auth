<?php

namespace DevPledge\Application\Commands;


use DevPledge\Domain\ThirdPartyAuth\EmailPassword;
use DevPledge\Domain\ThirdPartyAuth\ThirdPartyAuth;
use DevPledge\Integrations\Command\AbstractCommand;

/**
 * Class CreateUserCommand
 * @package DevPledge\Application\Commands
 */
class CreateUserCommand extends AbstractCommand {
	/**
	 * @var EmailPassword
	 */
	private $thirdPartyAuth;

	/**
	 * CreateUserCommand constructor.
	 *
	 * @param ThirdPartyAuth $thirdPartyAuth
	 */
	public function __construct( ThirdPartyAuth $thirdPartyAuth ) {
		$this->thirdPartyAuth = $thirdPartyAuth;
	}

	/**
	 * @return EmailPassword
	 */
	public function getThirdPartyAuth(): EmailPassword {
		return $this->thirdPartyAuth;
	}

}