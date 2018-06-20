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
	 * @return User
	 */
	public function create( $data ): User {
		if ( $data instanceof \stdClass ) {
			$data = (array) $data;
		}
		$user = new User();

		$set = function ( $key, $setMethod, $dateTime = false ) use ( $data, $user ) {
			if ( ( $data ) && array_key_exists( $key, $data ) && isset( $data[ $key ] ) ) {

				if ( is_callable( array( $user, $setMethod ) ) ) {
					if ( $dateTime ) {
						$user->{$setMethod}( new \DateTime( $data[ $key ] ) );
					} else {
						$user->{$setMethod}( $data[ $key ] );
					}
				}
			}
		};

		$set( 'user_id', 'setId' );
		$set( 'username', 'setUsername' );
		$set( 'name', 'setName' );
		$set( 'email', 'setEmail' );
		$set( 'hashed_password', 'setHashedPassword' );
		$set( 'github_id', 'setGitHubId' );
		$set( 'created', 'setCreated', true );
		$set( 'modified', 'setModified', true );

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
		if ( array_key_exists( 'developer', $data ) ) {
			$user->setDeveloper( (bool) $data['developer'] );
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