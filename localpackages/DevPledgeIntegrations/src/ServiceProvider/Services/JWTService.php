<?php

namespace DevPledge\Integrations\ServiceProvider\Services;

use DevPledge\Integrations\Security\JWT\JWT;
use DevPledge\Integrations\ServiceProvider\AbstractService;
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
		$secret    = $container->get( 'settings' )['security']['jwt']['secret'];
		$algorithm = $container->get( 'settings' )['security']['jwt']['algorithm'];
		$jwt       = new JWT( $secret, $algorithm, $container->get( JSON::class ) );

		$ttl = $container->get( 'settings' )['security']['jwt']['ttl'] ?? null;
		$ttr = $container->get( 'settings' )['security']['jwt']['ttr'] ?? null;

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