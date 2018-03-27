<?php

namespace DevPledge\Integrations;
use Slim\App;

/**
 * Class AbstractAppAccess
 * @package DevPledge\Integrations
 */
abstract class AbstractAppAccess {
	/**
	 * @var App
	 */
	protected static $app;

	/**
	 * @return App
	 */
	public function getApp(): App {
		return static::$app;
	}

	/**
	 * @param App $app
	 */
	public static function setApp( App $app ): void {
		static::$app = $app;
	}
}