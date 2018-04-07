<?php

namespace DevPledge\Application\Services;

use DevPledge\Application\Factory\OrganisationFactory;
use DevPledge\Application\Repository\OrganisationRepository;
use DevPledge\Domain\Organisation;
use DevPledge\Framework\FactoryDependencies\OrganisationFactoryDependency;
use DevPledge\Framework\RepositoryDependencies\OrganisationRepositoryDependency;
use DevPledge\Integrations\ServiceProvider\AbstractService;
use Slim\Container;

/**
 * Class OrganisationService
 * @package DevPledge\Application\Services
 */
class OrganisationService extends AbstractService {
	/**
	 * @var OrganisationRepository $repo
	 */
	protected $repo;
	/**
	 * @var OrganisationFactory $factory
	 */
	private $factory;

	/**
	 * OrganisationService constructor.
	 */
	public function __construct() {

		parent::__construct( static::class );
	}

	/**
	 * @param string $name
	 *
	 * @return \DevPledge\Domain\Organisation
	 * @throws \Exception
	 */
	public function create( string $name ) {
		$organisation = $this->factory->create( [
			'name' => $name,
		] );

		return $this->repo->create( $organisation );
	}


	/**
	 * @param Container $container
	 *
	 * @return $this
	 * @throws \Interop\Container\Exception\ContainerException
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
	public function __invoke( Container $container ) {
		$this->factory = OrganisationFactoryDependency::getFactory();

		/**
		 * This could work either way
		 */
		$this->repo = $container->get( OrganisationRepository::class );


		/**
		 * or this way
		 */
		$this->repo = $this->getApp()->getContainer()->get( OrganisationRepository::class );


		/**
		 * or this way (which is best!!!!)
		 *
		 * This way gives you IDE helpers so you dont have to keep visually referencing other files
		 *
		 */
		$this->repo = OrganisationRepositoryDependency::getRepository();

		return $this;
	}

	/**
	 * usually return static::getFromContainer();
	 * @return $this
	 */
	static public function getService() {
		return static::getFromContainer();
	}
}