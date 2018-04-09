<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 25/03/2018
 * Time: 10:33
 */

namespace DevPledge\Framework\ControllerDependencies;


use DevPledge\Application\Services\OrganisationService;
use DevPledge\Framework\Controller\OrganisationController;
use DevPledge\Integrations\ControllerDependency\AbstractControllerDependency;
use Slim\Container;

/**
 * Class OrganisationControllerDependency
 * @package DevPledge\Framework\ControllerDependencies
 */
class OrganisationControllerDependency extends AbstractControllerDependency {
	/**
	 * OrganisationControllerDependency constructor.
	 */
	public function __construct() {
		parent::__construct( OrganisationController::class );
	}

	/**
	 * @param Container $container
	 *
	 * @return OrganisationController
	 */
	public function __invoke( Container $container ) {
		$organisationService = OrganisationService::getService();

		return new OrganisationController( $organisationService );
	}

	/**
	 * @return OrganisationController
	 */
	static public function getController() {
		return static::getFromContainer();
	}
}