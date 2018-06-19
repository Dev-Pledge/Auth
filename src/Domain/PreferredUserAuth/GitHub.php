<?php

namespace DevPledge\Domain\PreferredUserAuth;


use DevPledge\Domain\User;
use DevPledge\Integrations\Curl\CurlRequest;

/**
 * Class GitHub
 * @package DevPledge\Domain\ThirdPartyAuth
 */
class GitHub implements PreferredUserAuth {
	/**
	 * @var int
	 */
	private $githubId;
	/**
	 * @var string
	 */
	private $accessToken;

	/**
	 * GitHub constructor.
	 *
	 * @param int $gitHubId
	 * @param string $accessToken
	 */
	public function __construct( int $gitHubId, string $accessToken ) {
		$this->githubId    = $gitHubId;
		$this->accessToken = $accessToken;
	}

	/**
	 * @return bool
	 * @throws PreferredUserAuthValidationException
	 */
	public function validate(): void {
		if ( ! ( strlen( $this->getGithubId() ) > 3 && is_numeric( $this->getGithubId() ) ) ) {
			throw new PreferredUserAuthValidationException( 'Github Id is not valid' );
		}
		$githubCall = new CurlRequest( 'https://api.github.com/user/' . $this->githubId );
		$response   = $githubCall->get()->setHeaders(
			[ 'Authorization' => $this->accessToken ]
		)->getDecodedJsonResponse();
		if ( (
			     isset( $response->message ) && strpos( $response->message, 'Bad Response' ) !== false
		     ) || $githubCall->getHttpCode() == '401' ) {
			throw new PreferredUserAuthValidationException( 'Github Access Token not Authorised', 'github' );
		}

	}

	/**
	 * @param User $user
	 */
	public function updateUserWithAuth( User $user ): void {
		$user->setGitHubId( $this->getGithubId() );
	}

	/**
	 * @return int
	 */
	public function getGithubId(): int {
		return $this->githubId;
	}

	/**
	 * @return array
	 */
	public function getAuthDataArray() {
		return [ 'github_id' => $this->getGithubId() ];
	}
}