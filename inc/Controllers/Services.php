<?php
/**
 * Handler Controller
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace MWF\Plugin\Controllers;

use MWF\Plugin\DI\ContainerBuilder,
	MWF\Plugin\Services as Service,
	MWF\Plugin\Interfaces,
	MWF\Plugin\Abstracts;

/**
 * Controls the registration and execution of services
 *
 * @subpackage Controllers
 */
class Services extends Abstracts\Controller
{
	/**
	 * Constructor for new instances
	 *
	 * @param Interfaces\Services\Compiler $compiler : Compiler service instance.
	 * @param Interfaces\Services\Router   $router : Router service instance.
	 */
	public function __construct(
		protected Interfaces\Services\Compiler $compiler,
		protected Interfaces\Services\Router $router
	) {
		parent::__construct();
	}
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
	 * Actions to perform when the class is loaded
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_filter( 'timber/twig', [ $this->compiler, 'loadFunctions' ] );
		add_filter( 'timber/twig', [ $this->compiler, 'loadFilters' ] );
		add_filter( 'timber/locations', [ $this->compiler, 'templateLocations' ] );

		add_action( 'wp', [ $this->router, 'loadRoute' ] );
		add_action( 'admin_init', [ $this->router, 'loadRoute' ] );
		add_action( 'login_init', [ $this->router, 'loadRoute' ] );
	}
}
