<?php

namespace DevPledge\Framework\Controller\User;


use DevPledge\Application\Commands\CreateUserCommand;
use DevPledge\Domain\PreferredUserAuth\UsernameEmailPassword;
use DevPledge\Domain\PreferredUserAuth\GitHub;
use DevPledge\Domain\PreferredUserAuth\PreferredUserAuth;
use DevPledge\Domain\PreferredUserAuth\PreferredUserAuthValidationException;
use DevPledge\Domain\PreferredUserAuth\UsernamePassword;
use DevPledge\Domain\TokenString;
use DevPledge\Domain\User;
use DevPledge\Framework\ServiceProviders\UserServiceProvider;
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
		if ( isset( $username ) ) {
			$user = UserServiceProvider::getService()->getByUsername( $username );
			if ( $user->getUsername() != $username ) {
				return $response->withJson( [ 'available' => true ] );
			}
		}

		return $response->withJson( [ 'available' => false ] );

	}

	/**
	 * @param $username
	 * @param PreferredUserAuth $preferredUserAuth
	 * @param Response $response
	 *
	 * @return Response
	 */
	private function creationResponse( PreferredUserAuth $preferredUserAuth, Response $response ) {

		try {
			try {
				$user = Dispatch::command( new CreateUserCommand( $preferredUserAuth, $response ) );
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
			$token = new TokenString( $user, $this->jwt );

			return $response->withJson(
				[
					'user_id'  => $user->getId(),
					'username' => $user->getUsername(),
					'token'    => $token->getTokenString()
				]
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
			$preferredUserAuth = new UsernameEmailPassword( $username, $email, $password );

			return $this->creationResponse( $preferredUserAuth, $response );
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

		$githubId    = $data['github_id'] ?? null;
		$accessToken = $data['access_token'] ?? null;
		$username    = $data['username'] ?? null;

		if ( isset( $githubId ) && isset( $username ) && isset( $accessToken ) ) {
			$preferredUserAuth = new GitHub( $username, $githubId, $accessToken );

			return $this->creationResponse( $preferredUserAuth, $response );
		}

		return $response->withJson(
			[ 'error' => 'Github ID, GitHub Access Token and Username not set' ]
			, 401
		);
	}

}