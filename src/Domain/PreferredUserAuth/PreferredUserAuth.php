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
	 * @return array
	 */
	public function getAuthDataArray();

}