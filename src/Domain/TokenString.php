<?php

namespace DevPledge\Domain;

/**
 * Class TokenString
 * @package DevPledge\Domain
 */
class TokenString {
	/**
	 * @var User
	 */
	private $user;
	/**
	 * @var JWT
	 */
	private $jwt;
	/**
	 * @var string
	 */
	private $token;

	/**
	 * Token constructor.
	 *
	 * @param User $user
	 * @param JWT $jwt
	 */
	public function __construct( User $user, JWT $jwt ) {
		$this->jwt  = $jwt;
		$this->user = $user;
	}

	/**
	 * @return string
	 */
	public function getTokenString() {

		if ( isset( $this->token ) ) {
			return $this->token;
		}

		$wildCardPermissions = new WildCardPermissions();
		$user                = $this->user;
		$token               = $this->jwt->generate( (object) [
			'name'     => $user->getName(),
			'username' => $user->getUsername(),
			'perms'    => $wildCardPermissions->getPerms()
		] );

		return $this->token = $token;

	}
}