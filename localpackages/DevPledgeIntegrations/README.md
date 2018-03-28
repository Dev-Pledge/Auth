# SlimIntegrations
DevPledge Standard Slim Integrations

Example usage

```
require __DIR__ . '/../dotenv.php';

Integrations::initSentry( getenv( 'SENTRY_DSN' ) );
Integrations::initApplication( require __DIR__ . '/../src/settings.php' );
Integrations::addCommonSettings();
Integrations::addCommonServices();
Integrations::addCommonHandlers();
Integrations::addExtrapolations( [
	new ExtrapolateSettings( __DIR__ . '/../src/Framework/Settings', "DevPledge\\Framework\\Settings" ),
	new ExtrapolateServices( __DIR__ . '/../src/Framework/Services', "DevPledge\\Framework\\Services" ),
	new ExtrapolateRepositoryDependencies( __DIR__ . '/../src/Framework/RepositoryDependencies', "DevPledge\\Framework\\RepositoryDependencies" ),
	new ExtrapolateControllerDependencies( __DIR__ . '/../src/Framework/ControllerDependencies', "DevPledge\\Framework\\ControllerDependencies" ),
	new ExtrapolateFactoryDependencies( __DIR__ . '/../src/Framework/FactoryDependencies', "DevPledge\\Framework\\FactoryDependencies" ),
	new ExtrapolateRouteGroups( __DIR__ . '/../src/Framework/RouteGroups', "DevPledge\\Framework\\RouteGroups" )
] );

Integrations::run();
```
