<?php

namespace DevPledge\Application\Factory;
use DevPledge\Domain\Organisation;

/**
 * Class OrganisationFactory
 * @package DevPledge\Application\Factory
 */
class OrganisationFactory {
	/**
	 * @param $data
	 *
	 * @return Organisation
	 */
	public function create( $data ):Organisation {
		/**
		 * TODO implement this properly???  Maybe Tom has other ideas how this works???
		 */
		$organistaion =  new Organisation();
		$organistaion->setName( $data['name']);
		return $organistaion;
	}

}