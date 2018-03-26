<?php

namespace DevPledge\Integrations\Middleware;

use DevPledge\Integrations\AbstractAppAccess;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class AbstractMiddleware extends AbstractAppAccess {
	abstract public function __invoke( Request $request, Response $response, callable $next );
}