<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 25/03/2018
 * Time: 02:42
 */

namespace DevPledge\Integrations\ServiceProvider\Services;

use DevPledge\Integrations\ServiceProvider\AbstractService;
use Slim\Container;
use TomWright\Database\ExtendedPDO\ExtendedPDO;

/**
 * Class ExtendedPDOService
 * @package DevPledge\Integrations\ServiceProvider\Services
 */
class ExtendedPDOService extends AbstractService {
	/**
	 * ExtendedPDOService constructor.
	 */
	public function __construct() {
		parent::__construct( ExtendedPDO::class );
	}

	/**
	 * @param Container $container
	 *
	 * @return mixed|ExtendedPDO
	 * @throws \Interop\Container\Exception\ContainerException
	 */
	public function __invoke( Container $container ) {
		$db = new ExtendedPDO(
			$container->get( 'settings' )['database']['dsn'],
			$container->get( 'settings' )['database']['user'],
			$container->get( 'settings' )['database']['pass']
		);
		$db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );

		return $db;
	}

	/**
	 * @return ExtendedPDO;
	 */
	public static function getService() {
		return static::getFromContainer();
	}
}