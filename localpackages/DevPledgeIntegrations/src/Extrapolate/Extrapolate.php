<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 25/03/2018
 * Time: 13:59
 */

namespace DevPledge\Integrations\Extrapolate;

/**
 * Class Extrapolate
 * @package DevPledge\Integrations\Extrapolate
 */
class Extrapolate {
	/**
	 * @param AbstractExtrapolate[] $extrapolations
	 */
	public static function extrapolate( array $extrapolations ) {
		if ( count( $extrapolations ) ) {
			foreach ( $extrapolations as $ext ) {
				if ( $ext instanceof AbstractExtrapolate ) {
					call_user_func_array( $ext, array() );
				}
			}
		}
	}
}