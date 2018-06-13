<?php

namespace DevPledge\Domain\ThirdPartyAuth;

use DevPledge\Domain\User;

/**
 * Class EmailPassword
 * @package DevPledge\Domain\ThirdPartyAuth
 */
class EmailPassword implements ThirdPartyAuth {

	private $email;
	private $password;
	private $hashedPassword;

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
	 * @param string $password
	 *
	 * @return EmailPassword
	 */
	public function setPassword( string $password ): EmailPassword {
		$this->password = $password;

		return $this;
	}

	/**
	 * @throws ThirdPartyAuthValidationException
	 */
	public function validate(): void {

		if ( ! ( isset( $this->password ) ) ) {
			throw new ThirdPartyAuthValidationException( 'Password Required', 'password' );
		}

		if ( ! filter_var( $this->email, FILTER_VALIDATE_EMAIL ) ) {
			throw new ThirdPartyAuthValidationException( 'Email is not formatted correctly', 'email' );
		}
		if ( preg_match( '/\A(?=[\x20-\x7E]*?[A-Z])(?=[\x20-\x7E]*?[a-z])(?=[\x20-\x7E]*?[0-9])[\x20-\x7E]{6,}\z/', $this->password ) ) {
			throw new ThirdPartyAuthValidationException( 'Passwords are required to have Uppercase, Lowercase, Symbols and more than 6 characters', 'password' );
		}
		if ( ! isset( $this->hashedPassword ) ) {
			$this->setHashedPassword( $this->encrypt( $this->password ) );
		}
		$hashedPasswordArray = explode( ":", $this->getHashedPassword() );

		if ( ! (
			isset( $hashedPasswordArray[1] ) &&
			$this->encrypt( $this->password, $hashedPasswordArray[1] ) == $this->getHashedPassword()
		) ) {
			throw new ThirdPartyAuthValidationException( 'Password and Email do not match', 'password' );
		}
	}

	/**
	 * @return string
	 */
	public function getHashedPassword(): string {
		return $this->hashedPassword;
	}

	/**
	 * @param null|string $hashedPassword
	 *
	 * @return EmailPassword
	 */
	public function setHashedPassword( ?string $hashedPassword ): EmailPassword {
		$this->hashedPassword = $hashedPassword;

		return $this;
	}


	/**
	 * @param $password
	 * @param null $salt
	 *
	 * @return string
	 */
	private function encrypt( $password, $salt = null ) {

		if ( ! isset( $salt ) ) {

			$salt = $this->generateSalt();
		}

		$hash_password = crypt( $password, sprintf( '$2a$07$%s$', $salt ) );

		return $hash_password . ':' . $salt;
	}

	/**
	 * @param int $size
	 * @param int $t
	 *
	 * @return bool|string
	 */
	private function generateSalt( $size = 22, $t = 128 ) {
		$strong = false;
		if ( function_exists( 'openssl_random_pseudo_bytes' ) ) {
			$secureString = openssl_random_pseudo_bytes( $size + ( $t * 1024 ), $strong );
		}
		if ( ! $strong && function_exists( 'mcrypt_create_iv' ) ) {
			$secureString = mcrypt_create_iv( $size + ( $t * 1024 ), MCRYPT_DEV_URANDOM );
		} else if ( ! $strong ) {
			$fp           = fopen( '/dev/urandom', 'r' );
			$secureString = fread( $fp, $size + ( $t * 1024 ) );
			fclose( $fp );
		}
		// return a string valid for crypt blowfish
		$secureString = str_replace( array( '=', '+', '/' ), '', base64_encode( $secureString ) );

		return substr( $secureString, - $size );
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
}