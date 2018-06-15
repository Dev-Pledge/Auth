<?php

namespace DevPledge\Framework\Controller\User;


use DevPledge\Application\Commands\CreateUserCommand;
use DevPledge\Domain\PreferredUserAuth\EmailPassword;
use DevPledge\Domain\PreferredUserAuth\GitHub;
use DevPledge\Domain\PreferredUserAuth\PreferredUserAuth;
use DevPledge\Domain\PreferredUserAuth\PreferredUserAuthValidationException;
use DevPledge\Domain\PreferredUserAuth\UsernamePassword;
use DevPledge\Domain\User;
use DevPledge\Integrations\Command\Dispatch;
use DevPledge\Integrations\Security\JWT\JWT;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class UserController
 * @package DevPledge\Framework\Controller\User
 */
class UserCreateController {
	/**
	 * @var JWT
	 */
	private $jwt;

	/**
	 * UserCreateController constructor.
	 *
	 * @param JWT $jwt
	 */
	public function __construct( JWT $jwt ) {
		$this->jwt = $jwt;
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 *
	 * @return Response
	 */
	public function checkUsernameAvailability( Request $request, Response $response ) {
		$data     = $request->getParsedBody();
		$username = $data['username'] ?? null;

		return $response;


	}

	/**
	 * @param Request $request
	 * @param Response $response
	 *
	 * @return Response
	 */
	public function createUserFromUsernamePassword( Request $request, Response $response ) {
		$data = $request->getParsedBody();

		$password = $data['password'] ?? null;
		$username = $data['username'] ?? null;

		if ( isset( $password ) && isset( $username ) ) {
			$preferredUserAuth = new UsernamePassword( $username, $password );

			return $this->creationResponse( $username, $preferredUserAuth, $response );
		}

		return $response->withJson(
			[ 'error' => 'Username and Password not set' ]
			, 401
		);


	}

	/**
	 * @param $username
	 * @param PreferredUserAuth $preferredUserAuth
	 * @param Response $response
	 *
	 * @return Response
	 */
	private function creationResponse( $username, PreferredUserAuth $preferredUserAuth, Response $response ) {
		$user = false;
		try {
			try {
				$user = Dispatch::command( new CreateUserCommand( $username, $preferredUserAuth, $response ) );
			} catch ( \PDOException $PDoException ) {
				throw new PreferredUserAuthValidationException(
					'Unable to create new user'
				);
			}
		} catch ( PreferredUserAuthValidationException $exception ) {
			return $response->withJson(
				[ 'error' => $exception->getMessage(), 'field' => $exception->getField() ]
				, 401 );
		}
		if ( $user instanceof User ) {
			return $response->withJson(
				[ 'user_id' => $user->getId(), 'username' => $user->getUsername() ]
			);
		}

		return $response->withJson(
			[ 'error' => 'failed' ]
			, 401
		);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 *
	 * @return Response
	 */
	public function createUserFromEmailPassword( Request $request, Response $response ) {
		$data = $request->getParsedBody();

		$email    = $data['email'] ?? null;
		$password = $data['password'] ?? null;
		$username = $data['username'] ?? null;

		if ( isset( $email ) && isset( $password ) && isset( $username ) ) {
			$preferredUserAuth = new EmailPassword( $email, $password );

			return $this->creationResponse( $username, $preferredUserAuth, $response );
		}

		return $response->withJson(
			[ 'error' => 'Email, Username and Password not all set' ]
			, 401
		);
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 *
	 * @return Response
	 */
	public function createUserFromGitHub( Request $request, Response $response ) {
		$data = $request->getParsedBody();

		$githubId = $data['github_id'] ?? null;
		$username = $data['username'] ?? null;

		if ( isset( $githubId ) && isset( $username ) ) {
			$preferredUserAuth = new GitHub( $githubId );

			return $this->creationResponse( $username, $preferredUserAuth, $response );
		}

		return $response->withJson(
			[ 'error' => 'Github ID, Username not set' ]
			, 401
		);
	}

}