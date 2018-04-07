<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 25/03/2018
 * Time: 10:33
 */

namespace DevPledge\Framework\ControllerDependencies;


use DevPledge\Application\Repository\Organisation\OrganisationRepository;
use DevPledge\Framework\Controller\OrganisationController;
use DevPledge\Framework\RepositoryDependencies\OrganisationRepositoryDependency;
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
		$organisationRepository = OrganisationRepositoryDependency::getRepository();

		return new OrganisationController( $organisationRepository );
	}

	/**
	 * @return OrganisationController
	 */
	static public function getController() {
		return static::getFromContainer();
	}
}