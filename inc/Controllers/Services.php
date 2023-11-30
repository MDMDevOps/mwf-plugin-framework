<?php
/**
 * Handler Controller
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Controllers;

use Mwf\Lib\DI\ContainerBuilder,
	Mwf\Lib\Deps\DI\Attribute\Inject,
	Mwf\Lib\DI\OnMount,
	Mwf\Lib\Services as Service,
	Mwf\Lib\Interfaces,
	Mwf\Lib\Traits,
	Mwf\Lib\Abstracts,
	Mwf\Lib\Helpers;

/**
 * Controls the registration and execution of services
 *
 * @subpackage Controllers
 */
class Services extends Abstracts\Mountable implements Interfaces\Controller
{
	/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return [
			/**
			 * Class implementations
			 */
			Service\Router::class               => ContainerBuilder::autowire(),
			Service\Compiler::class             => ContainerBuilder::autowire(),
			/**
			 * Interfaces mapping
			 */
			Interfaces\Services\Router::class   => ContainerBuilder::get( Service\Router::class ),
			Interfaces\Services\Compiler::class => ContainerBuilder::get( Service\Compiler::class ),
		];
	}
	/**
	 * Mount router functions/filters
	 *
	 * @param Interfaces\Services\Router $router : instance of router service.
	 *
	 * @return void
	 */
	#[OnMount]
	public function mountRouter( Interfaces\Services\Router $router ): void
	{
		add_action( 'wp', [ $router, 'loadRoute' ] );
		add_action( 'admin_init', [ $router, 'loadRoute' ] );
		add_action( 'login_init', [ $router, 'loadRoute' ] );
	}
	/**
	 * Mount compiler filters & add twig functions
	 *
	 * @param Interfaces\Services\Compiler $compiler : instance of compiler service.
	 *
	 * @return void
	 */
	#[OnMount]
	public function mountCompiler( Interfaces\Services\Compiler $compiler ): void
	{
		add_filter( 'timber/twig', [ $compiler, 'loadFunctions' ] );
		add_filter( 'timber/twig', [ $compiler, 'loadFilters' ] );
		add_filter( 'timber/locations', [ $compiler, 'templateLocations' ] );

		add_action( "{$this->package}_render_template", [ $compiler, 'render' ], 10, 2 );
		add_filter( "{$this->package}_compile_template", [ $compiler, 'compile' ], 10, 2 );

		add_action( "{$this->package}_render_string", [ $compiler, 'renderString' ], 10, 2 );
		add_filter( "{$this->package}_compile_string", [ $compiler, 'compileString' ], 10, 2 );

		$compiler->addFunction( 'has_action', 'has_action' );
		$compiler->addFunction( 'do_action', 'do_action' );
		$compiler->addFunction( 'apply_filters', 'apply_filters' );
		$compiler->addFunction(
			'do_function',
			[ Helpers::class, 'doFunction' ],
			[ 'is_variadic' => true ]
		);
	}
}
