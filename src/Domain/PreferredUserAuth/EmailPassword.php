<?php

namespace DevPledge\Domain\PreferredUserAuth;

use DevPledge\Domain\User;

/**
 * Class EmailPassword
 * @package DevPledge\Domain\ThirdPartyAuth
 */
class EmailPassword implements PreferredUserAuth {

	use PasswordTrait;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * EmailPassword constructor.
	 *
	 * @param string $email
	 * @param string|null $password
	 * @param string|null $hashedPassword
	 */
	public function __construct( string $email, string $password = null, string $hashedPassword = null ) {
		$this->email = $email;
		if ( isset( $password ) ) {
			$this->setPassword( $password );
		}
		if ( isset( $hashedPassword ) ) {
			$this->setHashedPassword( $hashedPassword );
		}
	}


	/**
	 * @throws PreferredUserAuthValidationException
	 */
	public function validate(): void {

		if ( ! filter_var( $this->email, FILTER_VALIDATE_EMAIL ) ) {
			throw new PreferredUserAuthValidationException( 'Email is not formatted correctly', 'email' );
		}

		$this->validatePassword();

	}


	/**
	 * @return string
	 */
	public function getEmail(): string {
		return $this->email;
	}

	/**
	 * @param User $user
	 */
	public function updateUserWithAuth( User $user ): void {
		$user->setHashedPassword( $this->getHashedPassword() );
		$user->setEmail( $this->getEmail() );
	}

	/**
	 * @return array
	 */
	public function getAuthDataArray() {
		return [
			'hashed_password' => $this->getHashedPassword(),
			'email'           => $this->getEmail()
		];
	}
}