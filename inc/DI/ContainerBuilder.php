<?php
/**
 * Container Builder
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace App\DI;

use DI\Definition\Source\DefinitionSource,
	DI\Definition\Reference,
	DI\Definition\Helper;

use App\Interfaces;

/**
 * Builder for Service Containers
 *
 * @subpackage DI
 */
class ContainerBuilder extends \DI\ContainerBuilder
{
	/**
	 * Saved containers for later retrieval
	 *
	 * Used to cache containers, so services can be retrieved without
	 * singletons
	 *
	 * @var array<string, Container>
	 */
	protected static array $containers = [];
	/**
	 * Constructor for new instances
	 *
	 * Sets parent containerClass to DL\Container instead of default
	 */
	public function __construct()
	{
		parent::__construct( Container::class );
	}
	/**
	 * Get a cached service container
	 *
	 * @param string $container_id : name of cached container to retrieve.
	 *
	 * @return Container|null
	 */
	public static function locateContainer( string $container_id )
	{
		return isset( self::$containers[ $container_id ] ) ? self::$containers[ $container_id ] : null;
	}
	/**
	 * Save a service container to the cache
	 *
	 * @param string    $container_id : name of container to reference it by.
	 * @param Container $container : Container instance to cache.
	 *
	 * @return void
	 */
	public static function cacheContainer( string $container_id, Container $container ): void
	{
		self::$containers[ $container_id ] = $container;
	}
	/**
	 * Add definitions to the container.
	 *
	 * @param string|array<mixed>|DefinitionSource ...$definitions Can be an array of definitions, the
	 *                                                      name of a file containing definitions
	 *                                                      or a DefinitionSource object.
	 * @return $this
	 */
	public function addDefinitions( string|array|DefinitionSource ...$definitions ): self
	{
		foreach ( $definitions as $definition ) {
			$this->autowireControllers( $definition );
		}

		parent::addDefinitions( ...$definitions );

		return $this;
	}
	/**
	 * Autowire controller services
	 *
	 * @param string|array<mixed>|DefinitionSource $definitions : definitions to add.
	 *
	 * @return void
	 */
	protected function autowireControllers( string|array|DefinitionSource $definitions ): void
	{
		if ( is_array( $definitions ) ) {
			foreach ( $definitions as $key => $definition ) {

				if ( ! is_subclass_of( $definition, Helper\DefinitionHelper::class ) ) {
					continue;
				}

				$class = $definition->getDefinition( $key )->getClassName();

				if ( ! class_exists( $class ) ) {
					continue;
				}

				$interfaces = class_implements( $class  );

				if ( in_array( Interfaces\Controller::class, $interfaces, true ) ) {
					$this->addDefinitions( $class::getServiceDefinitions() );
				}

				if ( in_array( Interfaces\Loadable::class, $interfaces, true ) ) {
					$definition->method( 'setPackage', self::get( 'app.package' ) )
						->method( 'load' );
				}
			}
		}
	}
	/**
	 * Wrapper for parent autowire function. Only used for simplicity
	 *
	 * @param string $class_name : name of service to autowire.
	 *
	 * @return Helper\DefinitionHelper
	 */
	public static function autowire( string $class_name = null ): Helper\DefinitionHelper
	{
		return \DI\autowire( $class_name );
	}
	/**
	 * Helper for defining an object.
	 *
	 * @param string|null $class_name Class name of the object.
	 *                               If null, the name of the entry (in the container) will be used as class name.
	 */
	public static function create( string $class_name = null ): Helper\DefinitionHelper
	{
		return \DI\create( $class_name );
	}
	/**
	 * Wrapper for parent get function. Only used for simplicity
	 *
	 * @param string $class_name : name of service to retrieve.
	 *
	 * @return Reference;
	 */
	public static function get( string $class_name ): Reference
	{
		return \DI\get( $class_name );
	}

	/**
	 * Helper for defining a container entry using a factory function/callable.
	 *
	 * @param callable|array<mixed>|string $factory The factory is a callable that takes the container as parameter
	 *        and returns the value to register in the container.
	 */
	public static function factory( callable|array|string $factory ): Helper\DefinitionHelper
	{
		return \DI\factory( $factory );
	}
}
