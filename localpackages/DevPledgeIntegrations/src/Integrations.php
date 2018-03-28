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
use DevPledge\Integrations\Setting\AddSetting;
use DevPledge\Integrations\Setting\Settings;
use DevPledge\Integrations\Setting\Settings\JWTSettings;
use DevPledge\Integrations\Setting\Settings\MysqlSettings;
use Psr\Http\Message\ResponseInterface;
use Slim\App;


/**
 * Class Integrations
 * @package DevPledge\Integrations
 */
class Integrations extends AbstractAppAccess {


	/**
	 * @param \Raven_Client $client
	 *
	 * @return \Raven_Client
	 */
	static public function setSentry( \Raven_Client $client ): \Raven_Client {
		return Sentry::setSentry( $client );
	}

	/**
	 * @param null $options_or_dsn
	 * @param array $options
	 *
	 * @return \Raven_Client
	 */
	static public function initSentry( $options_or_dsn = null, $options = array() ): \Raven_Client {
		return static::setSentry( new \Raven_Client( $options_or_dsn, $options ) );
	}

	/**
	 * @param array $container
	 *
	 * @return App
	 */
	static public function initApplication( $container = [] ) {

		$settings = new Settings();
		$settings->addInitialSetting( $container );

		return static::setApp( new App( $settings ) );
	}

	static public function addCommonSettings(): void {
		$settingAdder = new AddSetting();
		$settingAdder->addSetting( new MysqlSettings() )
		             ->addSetting( new JWTSettings() );
	}

	static public function addCommonServices(): void {
		$serviceAdder = new AddService();
		$serviceAdder->addService( new LoggerService() )
		             ->addService( new PHPRendererService() )
		             ->addService( new JSONService() )
		             ->addService( new ExtendedPDOService() )
		             ->addService( new JWTService() );
	}

	static public function addCommonHandlers(): void {
		$handlerAdder = new AddHandler();
		$handlerAdder->addHandler( new NotFoundHandler() )
		             ->addHandler( new NotAllowedHandler() );
	}

	/**
	 * @param array $extrapolations
	 * @param null $cachedExtrapolationsDir
	 */
	static public function addExtrapolations( array $extrapolations, $cachedExtrapolationsDir = null ) {
		Extrapolate::setCachedExtrapolationsDir( $cachedExtrapolationsDir );
		Extrapolate::extrapolate( $extrapolations );
	}


	/**
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws \Exception
	 * @throws \Slim\Exception\MethodNotAllowedException
	 * @throws \Slim\Exception\NotFoundException
	 */
	static public function run(): ResponseInterface {
		return static::$app->run();
	}

	/**
	 * @return mixed|\Slim\App
	 */
	static public function getApplication(): App {
		return static::$app;
	}
}