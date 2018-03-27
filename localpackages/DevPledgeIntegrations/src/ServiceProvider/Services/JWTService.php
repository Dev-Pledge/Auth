<?php

namespace DevPledge\Integrations\ServiceProvider\Services;

use DevPledge\Integrations\Security\JWT\JWT;
use DevPledge\Integrations\ServiceProvider\AbstractService;
use DevPledge\Integrations\Setting\Settings\JWTSettings;
use Slim\Container;
use TomWright\JSON\JSON;

/**
 * Class JWTService
 * @package DevPledge\Integrations\ServiceProvider\Services
 */
class JWTService extends AbstractService {
	/**
	 * JWTService constructor.
	 */
	public function __construct() {
		parent::__construct( JWT::class );
	}


	/**
	 * @param Container $container
	 *
	 * @return JWT|mixed
	 * @throws \Interop\Container\Exception\ContainerException
	 */
	public function __invoke( Container $container ) {
		$settings  = JWTSettings::getSetting();
		$secret    = $settings->getSecret();
		$algorithm = $settings->getAlgorithm();
		$jwt       = new JWT( $secret, $algorithm, JSONService::getService() );

		$ttl = $settings->getTimeToLive();
		$ttr = $settings->getTimeToRefresh();

		if ( $ttl !== null ) {
			$jwt->setTimeToLive( $ttl );
		}
		if ( $ttr !== null ) {
			$jwt->setTimeToRefresh( $ttr );
		}

		return $jwt;
	}

	/**
	 * @return JWT;
	 */
	static public function getService() {
		return static::getFromContainer();
	}
}