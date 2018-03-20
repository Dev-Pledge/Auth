<?php

use DevPledge\Application\Container\AddHandler;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

$addHandler = new AddHandler(
	'notFoundHandler',
	function ( Request $request, Response $response, Container $container ) {
		$data                    = new stdClass();
		$data->error             = 'Not Found';
		$data->errorStatus       = '404';
		$data->sentRequestBody   = $request->getBody();
		$data->sentRequestMethod = $request->getMethod();
		$data->sentAttributes    = $request->getAttributes();
		$data->sentParams        = $request->getParams();

		return $response->withJson( $data )->withStatus( 404 );
	} );
