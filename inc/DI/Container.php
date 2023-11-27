<?php
/**
 * Container definition file
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

use Mwf\Lib\Deps\DI,
	Mwf\Lib\Deps\DI\Definition\Definition,
	Mwf\Lib\Deps\DI\DependencyException,
	Mwf\Lib\Deps\DI\NotFoundException,
	Mwf\Lib\Deps\DI\Definition\Helper,
	Mwf\Lib\Deps\DI\Attribute\Inject,
	WP_Error;

use Mwf\Lib\Interfaces,
	Mwf\Lib\Traits,
	Mwf\Lib\Helpers;
	

/**
 * Service Container
 *
 * @subpackage DI
 */
final class Container extends DI\Container
{

    // private DefinitionResolver $definitionResolver;
	// private MutableDefinitionSource $definitionSource;
	/**
	 * Returns an entry of the container by its name.
	 *
	 * @param string $id : Entry name or a class name.
	 *
	 * @return mixed
	 *
	 * @throws DependencyException Error while resolving the entry.
	 * @throws NotFoundException No entry found for the given name.
	 */
	public function get( string $id ): mixed
	{
		/**
		 * If already resolved, just return...
		 */
		if ( isset( $this->resolvedEntries[ $id ] ) || array_key_exists( $id, $this->resolvedEntries ) ) {
            return $this->resolvedEntries[ $id ];
        }
		/**
		 * Else load new service
		 */
		try {
			$this->beforeGetService( $id );
			$instance = parent::get( $id );
			$this->afterGetService( $instance );
			return $instance;
		} catch ( DependencyException | NotFoundException $e ) {
			return new WP_Error( $e->getMessage() );
		}
	}
	/**
	 * Actions before a service is retrieved
	 *
	 * @param string $id : id of service to get from the container.
	 *
	 * @return void
	 */
	protected function beforeGetService( string $id ): void
	{
		if ( $this->has( 'app.package' ) ) {

			$definition = $this->getDefinition( $id );

			if ( ! method_exists( $definition, 'getClassName' ) ) {
				return;
			}

			do_action( "{$this->get( 'app.package' )}_before_get_service", $definition, $definition->getClassName(), $this );
		}
	}
	/**
	 * Actions to run after a service is retrieved
	 * 
	 * Checks for `OnMount` attributes, and fires those methods.
	 *
	 * @param mixed $instance : instance of service retrieved.
	 *
	 * @return void
	 */
	protected function afterGetService( mixed $instance ): void
	{
		if ( ! is_object( $instance ) ) {
			return;
		}

		$reflection = new \ReflectionClass( $instance );

		$callables = [];

		foreach ( $reflection->getMethods() as $method ) {
			
			$attributes = $method->getAttributes( OnMount::class );

			if ( empty( $attributes ) ) {
				continue;
			}

			foreach ( $attributes as $attribute ) {

				$att = $attribute->newInstance();

				$att->setParameters( $this->getInjectableAttributes( $method->getParameters() ) );

				$att->setMethod( $method->getName() );

				$callables[] = $att;
			}
		}
		/**
		 * Sort by priority 
		 */
		usort( $callables, function( OnMount $a, OnMount $b ) {
			return $a->getPriority() > $b->getPriority() ? 1 : 0;
		} );
		/**
		 * Fire callables
		 */
		foreach ( $callables as $callable ) {

			if ( empty( $callable->getMethod() ) ) {
				continue;
			}

			$this->call( [ $instance, $callable->getMethod() ], $callable->getParameters() );

		}
		/**
		 * Run action for additional decoration
		 */
		if ( $this->has( 'app.package' ) ) {
			do_action( "{$this->get( 'app.package' )}_after_get_service", $instance, $this );
		}
	}
	/**
	 * Get attributes that use `[Inject]` class
	 *
	 * @param array<ReflectionParameter> $parameters : array of reflection attributes.
	 *
	 * @return array
	 */
	protected function getInjectableAttributes( array $parameters ): array
	{
		$call_params = [];

		if ( ! empty( $parameters ) ) {

			foreach ( $parameters as $parameter ) {

				$injectables = $parameter->getAttributes( Inject::class );

				if ( ! empty( $injectables ) ) {

					foreach ( $injectables as $injectable ) {

						$inj = $injectable->newInstance();

						$call_params[ $parameter->getName() ] = $this->get( $inj->getName() );
					}
				}
			}
		}

		return $call_params;
	}
}
