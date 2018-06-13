<?php

namespace DevPledge\Application\Factory;


use DevPledge\Domain\User;

/**
 * Class UserFactory
 * @package DevPledge\Application\Factory
 */
class UserFactory {
	/**
	 * @param $data
	 *
	 * @return Organisation
	 */
	public function create( $data ): User {
		$user = new User();
		if ( array_key_exists( 'user_id', $data ) ) {
			$user->setId( $data['user_id'] );
		}
		if ( array_key_exists( 'username', $data ) ) {
			$user->setUsername( $data['username'] );
		}
		if ( array_key_exists( 'name', $data ) ) {
			$user->setName( $data['name'] );
		}
		if ( array_key_exists( 'email', $data ) ) {
			$user->setEmail( $data['email'] );
		}
		if ( array_key_exists( 'hashed_password', $data ) ) {
			$user->setHashedPassword( $data['hashed_password'] );
		}
		if ( array_key_exists( 'github_id', $data ) ) {
			$user->setHashedPassword( $data['github_id'] );
		}

		if ( array_key_exists( 'created', $data ) ) {
			$user->setCreated( new \DateTime( $data['created'] ) );
		}
		if ( array_key_exists( 'modified', $data ) ) {
			$user->setModified( new \DateTime( $data['modified'] ) );
		}

		return $user;
	}

	/**
	 * @param User $user
	 * @param array $data
	 *
	 * @return User
	 */
	public function update( User $user, array $data ): User {
		if ( array_key_exists( 'user_id', $data ) ) {
			$user->setId( $data['user_id'] );
		}
		if ( array_key_exists( 'username', $data ) ) {
			$user->setUsername( $data['username'] );
		}
		if ( array_key_exists( 'name', $data ) ) {
			$user->setName( $data['name'] );
		}
		if ( array_key_exists( 'email', $data ) ) {
			$user->setEmail( $data['email'] );
		}
		if ( array_key_exists( 'hashed_password', $data ) ) {
			$user->setHashedPassword( $data['email'] );
		}
		if ( array_key_exists( 'github_id', $data ) ) {
			$user->setHashedPassword( $data['github_id'] );
		}
		if ( array_key_exists( 'created', $data ) ) {
			$user->setCreated( new \DateTime( $data['created'] ) );
		}
		if ( array_key_exists( 'modified', $data ) ) {
			$user->setModified( new \DateTime( $data['modified'] ) );
		}

		return $user;
	}
}