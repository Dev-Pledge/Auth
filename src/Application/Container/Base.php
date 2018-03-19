<?php

namespace DevPledge\Application\Container;


use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class Base
 * @package DevPledge\Container
 */
abstract class Base {
	/**
	 * @var App
	 */
	protected $app;

	/**
	 * Base constructor.
	 *
	 * @param App $app
	 */
	public function __construct( App & $app ) {
		$this->setApp( $app );
	}

	/**
	 * @return App
	 */
	public function getApp(): App {
		return $this->app;
	}

	/**
	 * @param App $app
	 *
	 * @return $this
	 */
	public function setApp( App $app ) {
		$this->app = $app;

		return $this;
	}

	abstract public function do();
}