<?php
/**
 * Compiler Service Definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Services;

use Mwf\Lib\Abstracts,
	Mwf\Lib\Interfaces,
	Mwf\Lib\Traits,
	Mwf\Lib\Deps\Timber\Timber,
	Mwf\Lib\Deps\Timber\Loader,
	Mwf\Lib\Deps\Twig\TwigFunction,
	Mwf\Lib\Deps\Twig\TwigFilter,
	Mwf\Lib\Deps\Twig\Environment,
	Mwf\Lib\Deps\Twig\Error\SyntaxError;

use Mwf\Lib\Deps\DI\Attribute\Inject;

use LogicException;

/**
 * Service class to compile twig files and provide timber functions
 * - Add twig functions & filters
 * - Define template locations
 * - Filter timber context
 * - Add render and compile functions
 *
 * @subpackage Services
 */
class Compiler extends Abstracts\Mountable implements Interfaces\Services\Compiler, Interfaces\Handlers\Directory
{
	use Traits\Handlers\Directory;
	use Traits\Handlers\Environment;

	/**
	 * Twig functions to add
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $functions = [];
	/**
	 * Twig filters to add
	 *
	 * @var array<string, array<string, mixed>>
	 */
	protected array $filters = [];
	/**
	 * Cached template locations for timber to search for templates
	 *
	 * @var array<string>
	 */
	protected array $template_locations = [];
	/**
	 * Instance of twig
	 *
	 * @var ?Environment
	 */
	protected ?Environment $twig;
	/**
	 * Set the base directory - relative to the main plugin file
	 *
	 * Can include an additional string, to make it relative to a different file
	 *
	 * @param string $root : root path of the plugin.
	 * @param string      $append : string to append to base directory path.
	 *
	 * @return void
	 */
	#[Inject]
	public function setDir( #[Inject( 'views.dir' )] string $dir ): void
	{
		$this->dir = untrailingslashit( $dir );
	}
	/**
	 * Add the 'post' to context, if not already present.
	 *
	 * @param array<string, mixed> $context : optional context to merge.
	 *
	 * @return array<int, string>
	 */
	public function context( array $context = [] ): array
	{
		$context = array_merge( Timber::context(), $context );

		if ( ! isset( $context['post'] ) ) {
			global $post;

			if ( is_object( $post ) ) {
				$context['post'] = Timber::get_post( $post->ID );
			} elseif ( is_int( $post ) ) {
				$context['post'] = Timber::get_post( $post );
			}
		}
		return $context;
	}
	/**
	 * Filters the default locations array for twig to search for templates. We never use some paths, so there's
	 * no reason to waste overhead looking for templates there.
	 *
	 * @param array<int, string> $locations : Array of absolute paths to
	 *                                        available templates.
	 *
	 * @return array<int, string> $locations
	 */
	public function templateLocations( array $locations ): array
	{
		if ( empty( $this->template_locations ) ) {
			$this->template_locations = array_map( [$this, 'filterTemplateLocations'], $locations );

			$this->template_directory = apply_filters( 
				"{$this->package}_template_directory",
				$this->template_directory
			);

			$package_template_directories = array_unique(
				[
					trailingslashit( get_stylesheet_directory() . '/' . $this->template_directory ),
					trailingslashit( get_template_directory() . '/' . $this->template_directory ),
					trailingslashit( $this->dir() ),
				]
			);

			$this->template_locations[ $this->package ] = apply_filters(
				"{$this->package}_template_directories",
				$package_template_directories
			);
		}

		return $this->template_locations;
	}
	/**
	 * Recursive function to remove library locations from twig search
	 *
	 * @param string|array $location
	 *
	 * @return boolean|array|string
	 */
	protected function filterTemplateLocations( string|array $location ) : bool|array|string
	{
		if ( is_array( $location ) ) {
			$filtered_locations = array_filter(
				$location,
				function( $template_location ) {
					return $this->filterTemplateLocations( $template_location );
				}
			);
			return $filtered_locations;
		}
		elseif ( is_string( $location ) ) {
			return str_contains( $location, __DIR__ ) ? false : $location;
		}
		return $location;
	}
	/**
	 * Compile a twig/html template file using Timber
	 *
	 * @param string|array<int, string> $template_file : relative path to template file.
	 * @param array<string, mixed>      $context : additional context to pass to twig.
	 *
	 * @return string
	 */
	public function compile( $template_file, array $context = [] ): string
	{
		try {
			$template_file = is_array( $template_file ) ? $template_file : [ $template_file ];

			ob_start();

			Timber::render( $template_file, $this->context( $context ), 600, Loader::CACHE_NONE );

			$contents = ob_get_contents();

			return apply_filters( "{$this->package}_compiled", $contents );
		} catch ( SyntaxError $e ) {
			return $this->isDev() ? esc_html( $e->getMessage() ) : '';
		} finally {
			ob_end_clean();
		}
	}
	/**
	 * Compile a template file and return the content via a filter
	 *
	 * @param string                    $content : default content.
	 * @param string|array<int, string> $template_file : relative path of templates to compile.
	 * @param array<string, mixed>      $context : additional context to pass to templates.
	 *
	 * @return string
	 */
	public function compileByFilter( string $content, $template_file, array $context = [] ): string
	{
		$compiled = $this->compile( $template_file, $context );

		return ! empty( $compiled ) ? $compiled : $content;
	}
	/**
	 * Compile a string with timber/twig
	 *
	 * @param string               $content : string content to compile.
	 * @param array<string, mixed> $context : additional context to pass to twig.
	 *
	 * @return string
	 */
	public function compileString( string $content, array $context = [] ): string
	{
		try {
			ob_start();

			Timber::render_string( $content, $this->context( $context ) );

			return apply_filters( "{$this->package}_compiled", ob_get_contents() );
		} catch ( SyntaxError $e ) {
			return $this->isDev() ? esc_html( $e->getMessage() ) : '';
		} finally {
			ob_end_clean();
		}
	}
	/**
	 * Render a frontend twig template with timber/twig
	 *
	 * Wrapper for `compile` but outputs the content instead of returning it
	 * Ignored by PHPCS because we cannot escape at this time. Values should be
	 * escaped at the template level.
	 *
	 * @param string|array<int, string> $template_file : file to render.
	 * @param array<string, mixed>      $context : additional context to pass to twig.
	 *
	 * @return void
	 */
	public function render( $template_file, array $context = [] ): void
	{
		// phpcs:ignore
		echo $this->compile( $template_file, $context );
	}
	/**
	 * Render a string with timber/twig
	 *
	 * Wrapper for `compileString` but outputs the content instead of returning it
	 * Ignored by PHPCS because we cannot escape at this time. Values should be
	 * escaped at the template level.
	 *
	 * @param string               $content : string content to compile.
	 * @param array<string, mixed> $context : additional context to pass to twig.
	 *
	 * @return void
	 */
	public function renderString( string $content, array $context = [] ): void
	{
		// phpcs:ignore
		echo $this->compileString( $content, $context );
	}
	/**
	 * Getter for $functions that runs a filter once
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public function getFunctions(): array
	{
		return did_filter( "{$this->package}_twig_functions" )
			? $this->functions
			: apply_filters( "{$this->package}_twig_functions", $this->functions );
	}
	/**
	 * Getter for $filters that runs a filter once
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public function getFilters(): array
	{
		return did_filter( "{$this->package}_twig_filters" )
			? $this->filters
			: apply_filters( "{$this->package}_twig_filters", $this->filters );
	}
	/**
	 * Register custom function with TWIG
	 *
	 * @param Environment $twig : instance of twig environment.
	 *
	 * @return Environment
	 */
	public function loadFunctions( Environment $twig ): Environment
	{
		foreach ( $this->getFunctions() as $name => $args ) {
			try {
				$twig->AddFunction( new TwigFunction( $name, $args['callback'], $args['args'] ) );
			} catch ( LogicException $e ) {
				unset( $this->functions[ $name ] );
			}
		}
		return $twig;
	}
	/**
	 * Register custom filters with TWIG
	 *
	 * @param Environment $twig : instance of twig environment.
	 *
	 * @return Environment
	 */
	public function loadFilters( Environment $twig ): Environment
	{
		foreach ( $this->getFilters() as $name => $args ) {
			try {
				$twig->AddFilter( new TwigFilter( $name, $args['callback'], $args['args'] ) );
			} catch ( LogicException $e ) {
				unset( $this->filters[ $name ] );
			}
		}
		return $twig;
	}
	/**
	 * Add a function to collection of twig functions
	 *
	 * @param string                   $name : name of function to bind.
	 * @param string|array<int, mixed> $callback : callback function.
	 * @param array<string, mixed>     $args : args to add to twig function.
	 *
	 * @see https://twig.symfony.com/doc/3.x/advanced.html
	 * @see https://timber.github.io/docs/guides/extending-timber/
	 *
	 * @return void
	 */
	public function addFunction( string $name, string|array $callback, array $args = [] ): void
	{
		$this->functions[ $name ] = [
			'callback' => $callback,
			'args'     => $args,
		];
	}
	/**
	 * Add a filter to collection of twig functions
	 *
	 * @param string                   $name : name of filter to bind.
	 * @param string|array<int, mixed> $callback : callback function.
	 * @param array<string, mixed>     $args : args to add to twig filter.
	 *
	 * @see https://twig.symfony.com/doc/3.x/advanced.html
	 * @see https://timber.github.io/docs/guides/extending-timber/
	 *
	 * @return void
	 */
	public function addFilter( string $name, string|array $callback, array $args = [] ): void
	{
		$this->filters[ $name ] = [
			'callback' => $callback,
			'args'     => $args,
		];
	}
	/**
	 * Use twig to check if a given template exists in the defined paths
	 *
	 * @param string $name : which template to search for.
	 *
	 * @return boolean
	 */
	public function templateExists( string $name ): bool
	{
		if ( is_null( $this->twig ) ) {
			$loader = new Loader();

			$this->twig = $loader->get_twig();
		}
		return $this->twig->getLoader()->exists( $name );
	}
}
