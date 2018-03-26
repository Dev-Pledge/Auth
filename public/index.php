<?php

use DevPledge\Integrations\ControllerDependency\ExtrapolateControllerDependencies;
use DevPledge\Integrations\Extrapolate\Extrapolate;
use DevPledge\Integrations\FactoryDependency\ExtrapolateFactoryDependencies;
use DevPledge\Integrations\Integrations;
use DevPledge\Integrations\RepositoryDependency\ExtrapolateRepositoryDependencies;
use DevPledge\Integrations\ServiceProvider\ExtrapolateServices;


if ( PHP_SAPI == 'cli-server' ) {
	// To help the built-in PHP dev server, check if the request was actually for
	// something which should probably be served as a static file
	$url  = parse_url( $_SERVER['REQUEST_URI'] );
	$file = __DIR__ . $url['path'];
	if ( is_file( $file ) ) {
		return false;
	}
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

require __DIR__ . '/../dotenv.php';

/**
 * SENTRY SET UP
 */
Integrations::setSentry( new Raven_Client( getenv( 'SENTRY_DSN' ) ) );


/**
 * Instantiate the app
 */
$settings = require __DIR__ . '/../src/settings.php';
$app      = new \Slim\App( $settings );

Integrations::setApp( $app );

Integrations::addExtrapolations( [
	new ExtrapolateServices( __DIR__ . '/../src/Framework/ServicesDependencies', "DevPledge\\Framework\\ServicesDependencies" ),
	new ExtrapolateRepositoryDependencies( __DIR__ . '/../src/Framework/RepositoryDependencies', "DevPledge\\Framework\\RepositoryDependencies" ),
	new ExtrapolateControllerDependencies( __DIR__ . '/../src/Framework/ControllerDependencies', "DevPledge\\Framework\\ControllerDependencies" ),
	new ExtrapolateFactoryDependencies( __DIR__ . '/../src/Framework/FactoryDependencies', "DevPledge\\Framework\\FactoryDependencies" ),
] );

Integrations::addCommonServices();
Integrations::addCommonHandlers();


/**
 * Register routes
 */
require __DIR__ . '/../src/routes.php';

/**
 * Run app
 */
$app->run();



