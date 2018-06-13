<?php

namespace DevPledge\Domain\ThirdPartyAuth;


use DevPledge\Domain\User;

/**
 * Class GitHub
 * @package DevPledge\Domain\ThirdPartyAuth
 */
class GitHub implements ThirdPartyAuth {
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
	 * @throws ThirdPartyAuthValidationException
	 */
	public function validate(): void {
		if ( ! strlen( $this->getGithubId() ) > 3 ) {
			throw new ThirdPartyAuthValidationException( 'Github Id is not valid' );
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
}