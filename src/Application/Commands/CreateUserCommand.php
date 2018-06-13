<?php

namespace DevPledge\Application\Commands;


use DevPledge\Domain\PreferredUserAuth\EmailPassword;
use DevPledge\Domain\PreferredUserAuth\PreferredUserAuth;
use DevPledge\Integrations\Command\AbstractCommand;

/**
 * Class CreateUserCommand
 * @package DevPledge\Application\Commands
 */
class CreateUserCommand extends AbstractCommand {
	/**
	 * @var EmailPassword
	 */
	private $preferredUserAuth;
	/**
	 * @var string
	 */
	private $username;

	/**
	 * CreateUserCommand constructor.
	 *
	 * @param string $username
	 * @param PreferredUserAuth $preferredUserAuth
	 */
	public function __construct( string $username, PreferredUserAuth $preferredUserAuth ) {
		$this->username          = $username;
		$this->preferredUserAuth = $preferredUserAuth;

	}

	/**
	 * @return PreferredUserAuth
	 */
	public function getPreferredUserAuth(): PreferredUserAuth {
		return $this->preferredUserAuth;
	}

	/**
	 * @return string
	 */
	public function getUsername(): string {
		return $this->username;
	}


}