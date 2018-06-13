<?php

namespace DevPledge\Domain\ThirdPartyAuth;
use DevPledge\Domain\User;

/**
 * Interface ThirdPartyAuth
 * @package DevPledge\Domain\ThirdPartyAuth
 */
interface ThirdPartyAuth {
	/**
	 * @return bool
	 * @throws ThirdPartyAuthValidationException
	 */
	public function validate(): void;

	/**
	 * @param User $user
	 */
	public function updateUserWithAuth( User $user ): void;


}