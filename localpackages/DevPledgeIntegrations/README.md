# SlimIntegrations
DevPledge Standard Slim Integrations

Example usage

```
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
```
