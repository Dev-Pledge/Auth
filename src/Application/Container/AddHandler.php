<?php

namespace DevPledge\Application\Container;


use Slim\App;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AddHandler
 * @package DevPledge\Container
 */
class AddHandler extends Base {
	/**
	 * @var string
	 */
	protected $handlerName;
	/**
	 * @var \Closure
	 */
	protected $handlerFunction;

	/**
	 * AddHandler constructor.
	 *
	 * @param App $app
	 * @param $handlerName
	 * @param \Closure $handlerFunction
	 */
	public function __construct( App $app, $handlerName, \Closure $handlerFunction ) {
		parent::__construct( $app );
		$this->setHandlerName( $handlerName )
		     ->setHandlerFunction( $handlerFunction );
	}

	/**
	 * @return string
	 */
	public function getHandlerName(): string {
		return $this->handlerName;
	}

	/**
	 * @param string $handlerName
	 *
	 * @return AddHandler
	 */
	public function setHandlerName( string $handlerName ): AddHandler {
		$this->handlerName = $handlerName;

		return $this;
	}

	/**
	 * @return \Closure
	 */
	public function getHandlerFunction(): \Closure {
		return $this->handlerFunction;
	}

	/**
	 * @param \Closure $handlerFunction
	 *
	 * @return $this
	 */
	public function setHandlerFunction( \Closure $handlerFunction ) {
		$this->handlerFunction = $handlerFunction;

		return $this;
	}

	public function do() {
		$appContainer = $this->getApp()->getContainer();

		$appContainer[ $this->getHandlerName() ] = function ( Container $container ) {
			return function ( Request $request, Response $response ) use ( $container ) {
				return call_user_func_array( $this->getHandlerFunction(), array( $request, $response, $container ) );
			};
		};
	}

}