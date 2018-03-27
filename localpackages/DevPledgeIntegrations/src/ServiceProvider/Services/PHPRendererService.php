<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 25/03/2018
 * Time: 12:19
 */

namespace DevPledge\Integrations\ServiceProvider\Services;


use DevPledge\Integrations\ServiceProvider\AbstractService;
use Slim\Container;

class PHPRendererService extends AbstractService {
	public function __construct() {
		parent::__construct( 'renderer' );
	}

	public function __invoke( Container $container ) {
		$settings = $container->get( 'settings' )['renderer'];

		return new PHPRendererService( $settings['template_path'] );
	}
}