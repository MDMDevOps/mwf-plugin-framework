<?php
/**
 * Admin Service Definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Dispatchers;

use Mwf\Lib\Deps\DI\Attribute\Inject,
	Mwf\Lib\Abstracts,
	Mwf\Lib\Interfaces,
	Mwf\Lib\Traits;

/**
 * Style dispatcher service
 *
 * Used to register/enqueue CSS files with WP.
 *
 * @subpackage Dispatchers
 */
class Styles extends Abstracts\Mountable implements
	Interfaces\Dispatchers\Styles,
	Interfaces\Handlers\Directory,
	Interfaces\Handlers\Url
{
	use Traits\Handlers\Url;
	use Traits\Handlers\Directory;
	
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
	public function setDir( #[Inject( 'assets.dir' )] string $dir ): void
	{
		$this->dir = untrailingslashit( $dir );
	}
	/**
	 * Set the base URL
	 * Can include an additional string for appending to the URL of the plugin
	 *
	 * @param string $url : root directory to use.
	 *
	 * @return void
	 */
	#[Inject]
	public function setUrl( #[Inject( 'assets.url' )] string $url ): void
	{
		$this->url = untrailingslashit( $url );
	}
	/**
	 * Enqueue a style in the dist/build directories
	 *
	 * @param string             $handle : handle to register.
	 * @param string             $path : relative path to css file.
	 * @param array<int, string> $dependencies : any dependencies that should be loaded first, optional.
	 * @param string             $version : version of CSS file, optional.
	 * @param string             $screens : what screens to register for, optional.
	 *
	 * @return void
	 */
	public function enqueue(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = null,
		$screens = 'all'
	): void {
		$handle = $this->register( $handle, $path, $dependencies, $version, $screens );

		if ( wp_style_is( $handle, 'registered' ) ) {
			wp_enqueue_style( $handle );
		}
	}
	/**
	 * Register a CSS stylesheet with WP
	 *
	 * @param string             $handle : handle to register.
	 * @param string             $path : relative path to css file.
	 * @param array<int, string> $dependencies : any dependencies that should be loaded first, optional.
	 * @param string             $version : version of CSS file, optional.
	 * @param string             $screens : what screens to register for, optional.
	 *
	 * @return string
	 */
	public function register(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = null,
		$screens = 'all'
	): string {
		/**
		 * Get full file path
		 */
		$file = $this->dir( $path );
		/**
		 * Bail if local file, but empty
		 */
		if ( is_file( $file ) && ! filesize( $file ) ) {
			return $handle;
		}
		/**
		 * Load local assets if local file
		 */
		if ( is_file( $file ) ) {
			$version = $version ?? filemtime( $file );

			$handle = str_replace( [ '/', '\\', ' ' ], '-', $this->package ) . '-' . $handle;

			$path = $this->url( $path );
		}

		$valid = str_starts_with( $path, '//' )
			|| filter_var( $path, FILTER_VALIDATE_URL );

		if ( ! $valid ) {
			return $handle;
		}

		wp_register_style(
			$handle,
			$path,
			apply_filters( "{$this->package}_{$handle}_style_dependencies", $dependencies ),
			$version,
			$screens
		);

		return $handle;
	}
}
