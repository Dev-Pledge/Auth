<?php

namespace DevPledge\Integrations\Route;

use DevPledge\Integrations\AbstractAppAccess;
use DevPledge\Integrations\Middleware\AbstractMiddleware;
use function foo\func;

/**
 * Class AbstractRouteGroup
 */
abstract class AbstractRouteGroup extends AbstractAppAccess {
	/**
	 * @var string
	 */
	protected $pattern;
	/**
	 * @var AbstractMiddleware[]
	 */
	protected $middleware;

	/**
	 * AbstractRouteGroup constructor.
	 *
	 * @param $pattern
	 * @param AbstractMiddleware[]|null $middleware
	 *
	 * @throws Exception
	 */
	public function __construct( $pattern, array $middleware = null ) {
		$this->setPattern( $pattern )->setMiddleware( $middleware );
	}


	final public function __invoke() {
		$app   = $this->getApp();
		$that  = $this;
		$group = $app->group( '', function () use ( $app, $that ) {
			$app->group( $that->getPattern(),
				function () use ( $that ) {

					$that->setRoutesOnGroup();

				}
			);
		} );

		if ( $middleware = $this->getMiddleware() ) {
			foreach ( $middleware as $ware ) {
				$group->add( $ware );
			}

		}
	}

	abstract protected function setRoutesOnGroup();

	/**
	 * @param string $pattern
	 *
	 * @return AbstractRouteGroup
	 */
	public function setPattern( string $pattern ): AbstractRouteGroup {
		$this->pattern = $pattern;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPattern(): string {
		return $this->pattern;
	}

	/**
	 * @param array|null $middleware
	 *
	 * @return AbstractRouteGroup
	 * @throws Exception
	 */
	public function setMiddleware( array $middleware = null ): AbstractRouteGroup {
		if ( isset( $middleware ) && is_array( $middleware ) ) {
			foreach ( $middleware as $ware ) {
				if ( ! ( $ware instanceof AbstractMiddleware ) ) {
					throw new Exception( 'Must be Abstract Middleware ' );
				}
			}
		}
		$this->middleware = $middleware;

		return $this;
	}

	/**
	 * @return AbstractMiddleware[] | bool
	 */
	public function getMiddleware() {
		return isset( $this->middleware ) ? $this->middleware : false;
	}
}