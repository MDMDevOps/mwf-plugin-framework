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

namespace Mwf\Lib\DI;

use Mwf\Lib\Helpers,
	Mwf\Lib\Traits,
	Mwf\Lib\Interfaces,
	Mwf\Lib\Deps,
	Mwf\Lib\Deps\DI\Definition\Source\DefinitionSource,
	Mwf\Lib\Deps\DI\Definition\Reference,
	Mwf\Lib\Deps\DI\Definition\Helper;

/**
 * Builder for Service Containers
 *
 * @subpackage DI
 */
class ContainerBuilder extends Deps\DI\ContainerBuilder
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
			$this->prewireDefinitions( $definition );
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
	protected function prewireDefinitions( string|array|DefinitionSource $definitions, string $key = '' ): void
	{
		if ( is_array( $definitions ) ) {
			foreach ( $definitions as $key => $definition ) {
				if ( is_subclass_of( $definition, Helper\DefinitionHelper::class ) ) {
					$class_name = $definition->getDefinition( $key )->getClassName();
		
					if ( Helpers::implements( $class_name, Interfaces\Controller::class ) ) {
						$this->addDefinitions( $class_name::getServiceDefinitions() );
					}
				}
			}
		}
	}
	/**
	 * Wrapper for parent auto wire function. Only used for simplicity
	 *
	 * @param string $class_name : name of service to auto wire.
	 *
	 * @return Helper\DefinitionHelper
	 */
	public static function autowire( string $class_name = null ): Helper\DefinitionHelper
	{
		return Deps\DI\autowire( $class_name );
	}
	/**
	 * Helper for defining an object.
	 *
	 * @param string|null $class_name Class name of the object.
	 *                               If null, the name of the entry (in the container) will be used as class name.
	 */
	public static function create( string $class_name = null ): Helper\DefinitionHelper
	{
		return Deps\DI\create( $class_name );
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
		return Deps\DI\get( $class_name );
	}

	/**
	 * Helper for defining a container entry using a factory function/callable.
	 *
	 * @param callable|array<mixed>|string $factory The factory is a callable that takes the container as parameter
	 *        and returns the value to register in the container.
	 */
	public static function factory( callable|array|string $factory ): Helper\DefinitionHelper
	{
		return Deps\DI\factory( $factory );
	}
}
