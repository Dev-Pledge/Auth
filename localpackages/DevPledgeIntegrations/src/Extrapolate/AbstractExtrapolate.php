<?php
/**
 * Created by PhpStorm.
 * User: johnsaunders
 * Date: 26/03/2018
 * Time: 23:48
 */

namespace DevPledge\Integrations\Extrapolate;

/**
 * Class AbstractExtrapolate
 * @package DevPledge\Integrations\Extrapolate
 */
abstract class AbstractExtrapolate {
	/**
	 * @var string
	 */
	protected $nameSpace;
	/**
	 * @var string
	 */
	protected $path;
	/**
	 * @var AbstractContainerCallable | null
	 */
	protected $adapterClass;

	/**
	 * AbstractExtrapolate constructor.
	 *
	 * @param $path
	 * @param $nameSpace
	 * @param null $adapterClass
	 */
	public function __construct( $path, $nameSpace, $adapterClass = null ) {
		$this->setPath( $path )->setNameSpace( $nameSpace );
		$this->setAdapterClass( $adapterClass );
	}

	public function __invoke() {
		if ( is_dir( $this->path ) ) {
			$phpFiles = glob( $this->path . '/*.php' );
			if ( count( $phpFiles ) && $phpFiles ) {
				foreach ( glob( $this->path . '/*.php' ) as $filename ) {
					$split     = explode( '/', $filename );
					$className = str_replace( '.php', '', end( $split ) );
					$class     = $this->nameSpace . '\\' . $className;
					if ( $adapterClass = $this->getAdapterClass() ) {

						$this->extrapolate( new $adapterClass( new $class ) );

					} else {
						$this->extrapolate( new $class() );
					}

				}
			}
		}
	}

	/**
	 * @param string $path
	 *
	 * @return AbstractExtrapolateForContainer
	 */
	public function setPath( string $path ): AbstractExtrapolate {
		$this->path = $path;

		return $this;
	}

	/**
	 * @param string $nameSpace
	 *
	 * @return AbstractExtrapolateForContainer
	 */
	public function setNameSpace( string $nameSpace ): AbstractExtrapolate {
		$this->nameSpace = $nameSpace;

		return $this;
	}

	/**
	 * @param callable $callable
	 */
	protected function extrapolate( callable $callable ) {
		call_user_func( $callable );
	}

	/**
	 * @param string | null $adapterClass
	 *
	 * @return AbstractExtrapolateForContainer
	 */
	protected function setAdapterClass( string $adapterClass = null ) {
		$this->adapterClass = $adapterClass;

		return $this;
	}

	/**
	 * @return string|bool
	 */
	protected function getAdapterClass() {
		if ( isset( $this->adapterClass ) ) {
			return $this->adapterClass;
		}

		return false;
	}
}