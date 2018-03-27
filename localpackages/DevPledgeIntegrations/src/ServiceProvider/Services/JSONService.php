<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 25/03/2018
 * Time: 12:08
 */

namespace DevPledge\Integrations\ServiceProvider\Services;


use DevPledge\Integrations\ServiceProvider\AbstractService;
use Slim\Container;
use TomWright\JSON\JSON;

class JSONService extends AbstractService {
	public function __construct( ) {
		parent::__construct( JSON::class );
	}

	public function __invoke( Container $container ) {
		return new JSON();
	}
}