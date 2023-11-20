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
	Mwf\Lib\Services as Service,
	Mwf\Lib\Interfaces,
	Mwf\Lib\Abstracts;

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

		$this->compiler->addFunction( 'has_action', 'has_action' );
        $this->compiler->addFunction( 'do_action', 'do_action' );
        $this->compiler->addFunction( 'apply_filters', 'apply_filters' );
        $this->compiler->addFunction(
            'do_function',
            [ $this, 'doFunction' ],
            [ 'is_variadic' => true ]
        );

		add_action( 'wp', [ $this->router, 'loadRoute' ] );
		add_action( 'admin_init', [ $this->router, 'loadRoute' ] );
		add_action( 'login_init', [ $this->router, 'loadRoute' ] );
	}

	    /**
     * Wrapper to call functions from twig
     *
     * @param mixed ...$args : all arguments passed, unknown.
     *
     * @return mixed
     */
    public function doFunction( ...$args )
    {
        $function = array_shift( $args );
        ob_start();
        try {
            $output  = is_callable( $function ) ? call_user_func( $function, ...$args ) : null;
            $content = ob_get_clean();
            return $output ?? $content;
        } catch ( \Error $e ) {
            return null;
        }
    }
}
