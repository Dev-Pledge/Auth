<?php

namespace DevPledge\Domain\PreferredUserAuth;

use DevPledge\Domain\User;

/**
 * Interface ThirdPartyAuth
 * @package DevPledge\Domain\ThirdPartyAuth
 */
interface PreferredUserAuth {
	/**
	 * @return bool
	 * @throws ThirdPartyAuthValidationException
	 */
	public function validate(): void;

	/**
	 * @param User $user
	 */
	public function updateUserWithAuth( User $user ): void;

	/**
	 * all vars without username
	 * @return array
	 */
	public function getAuthDataArray();

	/**
	 * @return string
	 */
	public function getUsername();

}