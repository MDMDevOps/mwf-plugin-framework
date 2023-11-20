<?php
/**
 * Route Controller
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\App\Controllers;

use Mwf\Wp\App\DI\ContainerBuilder,
	Mwf\Wp\App\Abstracts,
	Mwf\Wp\App\Interfaces,
	Mwf\Wp\App\Routes as Route;

/**
 * Controls the registration and execution of Routes
 *
 * @subpackage Controllers
 */
class Routes extends Abstracts\Controller
{
	/**
	 * Construct new instance of the controller
	 *
	 * @param Interfaces\Services\Router $router : Instance of Services Router.
	 */
	public function __construct( protected Interfaces\Services\Router $router )
	{
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
			'route.frontend' => ContainerBuilder::autowire( Route\Frontend::class ),
			'route.admin'    => ContainerBuilder::autowire( Route\Frontend::class ),
			'route.login'    => ContainerBuilder::autowire( Route\Frontend::class ),
		];
	}
	/**
	 * Actions to perform when the class is loaded
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_action( 'wp', [ $this, 'loadRoute' ] );
		add_action( 'admin_init', [ $this, 'loadRoute' ] );
		add_action( 'login_init', [ $this, 'loadRoute' ] );
	}
	/**
	 * Load route specific classes
	 *
	 * @return void
	 */
	public function loadRoute(): void
	{
		foreach ( $this->router->getRoutes() as $route ) {
			$alias = 'route.' . strtolower( $route );

			$has_route = apply_filters( "{$this->package}_has_route", false, $alias );

			if ( ! $this->routeHasLoaded() && $has_route ) {
				do_action( "{$this->package}_load_route", $alias, $route );
			}

			do_action( "{$this->package}_route_{$route}", $alias );
		}
	}
	/**
	 * Determine if a route has already been loaded
	 *
	 * @return int
	 */
	public function routeHasLoaded(): int
	{
		return did_action( "{$this->package}_load_route" );
	}
}
