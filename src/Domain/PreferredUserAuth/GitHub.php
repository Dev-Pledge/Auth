<?php

namespace DevPledge\Domain\PreferredUserAuth;


use DevPledge\Domain\User;

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
	 * GitHub constructor.
	 *
	 * @param int $gitHubId
	 */
	public function __construct( int $gitHubId ) {
		$this->githubId = $gitHubId;
	}

	/**
	 * @return bool
	 * @throws PreferredUserAuthValidationException
	 */
	public function validate(): void {
		if ( ! ( strlen( $this->getGithubId() ) > 3 && is_numeric( $this->getGithubId() ) ) ) {
			throw new PreferredUserAuthValidationException( 'Github Id is not valid' );
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