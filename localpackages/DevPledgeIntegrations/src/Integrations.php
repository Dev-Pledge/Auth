<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 25/03/2018
 * Time: 21:14
 */

namespace DevPledge\Integrations;

use DevPledge\Integrations\Extrapolate\Extrapolate;
use DevPledge\Integrations\Handler\AddHandler;
use DevPledge\Integrations\Handler\Handlers\NotAllowedHandler;
use DevPledge\Integrations\Handler\Handlers\NotFoundHandler;
use DevPledge\Integrations\ServiceProvider\AddService;
use DevPledge\Integrations\ServiceProvider\Services\ExtendedPDOService;
use DevPledge\Integrations\ServiceProvider\Services\JSONService;
use DevPledge\Integrations\ServiceProvider\Services\JWTService;
use DevPledge\Integrations\ServiceProvider\Services\LoggerService;
use DevPledge\Integrations\ServiceProvider\Services\PHPRendererService;
use PHPUnit\Runner\Exception;
use Slim\App;

/**
 * Class Integrations
 * @package DevPledge\Integrations
 */
class Integrations extends AbstractAppAccess {

	static public function setSentry( \Raven_Client $client ) {
		Sentry::setSentry( $client );
	}

	static public function addCommonServices() {
		$serviceAdder = new AddService();
		$serviceAdder->addService( new LoggerService() )
		             ->addService( new PHPRendererService() )
		             ->addService( new JSONService() )
		             ->addService( new ExtendedPDOService() )
		             ->addService( new JWTService() );
	}

	static public function addCommonHandlers() {
		$handlerAdder = new AddHandler();
		$handlerAdder->addHandler( new NotFoundHandler() )
		             ->addHandler( new NotAllowedHandler() );
	}

	/**
	 * @param AbstractExtrapolate[] $extrapolations
	 */
	static public function addExtrapolations( array $extrapolations ) {
		Extrapolate::extrapolate( $extrapolations );
	}

	static public function run() {
		static::$app->run();
	}
}