<?php

namespace DevPledge\Framework\Controller\User;


use DevPledge\Application\Commands\CreateUserCommand;
use DevPledge\Domain\PreferredUserAuth\PreferredUserAuthValidationException;
use DevPledge\Domain\PreferredUserAuth\UsernamePassword;
use DevPledge\Integrations\Command\Dispatch;
use DevPledge\Integrations\Security\JWT\JWT;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class UserController
 * @package DevPledge\Framework\Controller\User
 */
class UserCreateController {

	public function __construct( JWT $jwt ) {
		$this->jwt = $jwt;
	}

	public function checkUsernameAvailability( Request $request, Response $response ) {
		$data     = $request->getParsedBody();
		$username = $data['username'] ?? null;

		return $response;


	}

	public function createUserFromUsernamePassword( Request $request, Response $response ) {
		$data = $request->getParsedBody();

		$password = $data['password'] ?? null;
		$username = $data['username'] ?? null;

		if ( isset( $password ) && isset( $username ) ) {
			$preferredUserAuth = new UsernamePassword( $username, $password );
			try {
				$user = Dispatch::command( new CreateUserCommand( $username, $preferredUserAuth, $response ) );
			} catch ( PreferredUserAuthValidationException $exception ) {
				return $response->withJson(
					[ 'error' => $exception->getMessage(), 'field' => $exception->getField() ]
					, 401 );
			}
			if ( $user ) {
				return $response->withJson(
					[ 'user' => $user->getId() ]
				);
			} else {
				return $response->withJson(
					[ 'error' => 'failed' ]
					, 401 );
			}
		} else {
			return $response->withJson(
				[ 'error' => 'Username and Password not set' ]
				, 401 );
		}

		return $response;
	}

	public function createUserFromEmailPassword( Request $request, Response $response ) {
		$data = $request->getParsedBody();

		$email    = $data['email'] ?? null;
		$password = $data['password'] ?? null;
		$username = $data['username'] ?? null;

		if ( isset( $email ) && isset( $password ) && isset( $username ) ) {

		}

		return $response;
	}

	public function createUserFromGitHub( Request $request, Response $response ) {

	}

	public function createUserFromFacebook( Request $request, Response $response ) {

	}
}