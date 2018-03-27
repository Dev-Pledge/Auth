<?php

namespace DevPledge\Integrations\Setting;

use Slim\Container as SlimContainer;

/**
 * Class Settings
 * @package DevPledge\Integrations\Setting
 */
class Settings extends SlimContainer {
	public function __construct( array $values = [] ) {
		parent::__construct( $values );
	}
}