<?php
/**
 * Admin Service Definition
 *
 * PHP Version 8.0.28
 *
 * @package Mwf\Wp\Lib
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\Lib\Dispatchers;

use Mwf\Wp\Lib\Abstracts,
	Mwf\Wp\Lib\Interfaces,
	Mwf\Wp\Lib\Traits;

/**
 * Service class to control admin functions
 * - Enqueues Admin CSS
 * - Enqueues Admin JS
 * - Adds Metaboxes
 *
 * @subpackage Dispatchers
 */
class Scripts extends Abstracts\Service implements Interfaces\Dispatchers\Scripts, Interfaces\Handlers\Assets, Interfaces\Handlers\Directory, Interfaces\Handlers\Url
{
	use Traits\AssetHandler;
	use Traits\UrlHandler;
	use Traits\DirectoryHandler;

	/**
	 * Get script assets from {handle}.asset.php
	 *
	 * @param string             $path : relative path to script.
	 * @param array<int, string> $dependencies : current dependencies passed, if any.
	 * @param string             $version : current version passed, if any.
	 *
	 * @return array<string, mixed>
	 */
	private function scriptAssets( string $path, array $dependencies = [], string $version = '' ): array
	{
		$asset_file = sprintf(
			'%s/%s.asset.php',
			$this->dir( $this->asset_dir ),
			str_ireplace( '.js', '', $path )
		);

		if ( is_file( $asset_file ) ) {
			$args = include $asset_file;

			$assets = [
				'dependencies' => wp_parse_args( $args['dependencies'], $dependencies ),
				'version'      => empty( $version ) ? $args['version'] : $version,
			];
		} else {
			$assets = [
				'dependencies' => $dependencies,
				'version'      => $version,
			];
		}

		return $assets;
	}
	/**
	 * Enqueue a script in the build/dist directories
	 *
	 * @param string             $handle : handle to register.
	 * @param string             $path : relative path to script.
	 * @param array<int, string> $dependencies : any set dependencies not in assets file, optional.
	 * @param string             $version : version of JS file, optional.
	 * @param boolean            $in_footer : whether to enqueue in footer, optional.
	 *
	 * @return void
	 */
	public function enqueue(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = '',
		$in_footer = true
	): void {

		$handle = $this->register( $handle, $path, $dependencies, $version, $in_footer );

		if ( wp_script_is( $handle, 'registered' ) ) {
			wp_enqueue_script( $handle );
		}
	}

	/**
	 * Register a JS file with WordPress
	 *
	 * @param string             $handle : handle to register.
	 * @param string             $path : relative path to script.
	 * @param array<int, string> $dependencies : any set dependencies not in assets file, optional.
	 * @param string             $version : version of JS file, optional.
	 * @param boolean            $in_footer : whether to enqueue in footer, optional.
	 *
	 * @return string
	 */
	public function register(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = '',
		$in_footer = true
	): string {
		/**
		 * Get full file path
		 */
		$file = $this->dir( "{$this->asset_dir}/{$path}" );
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
			$assets = $this->scriptAssets( $path, $dependencies, $version );

			$dependencies = $assets['dependencies'];

			$version = ! empty( $assets['version'] ) ? $assets['version'] : filemtime( $file );

			$handle = str_replace( [ '/', '\\', ' ' ], '-', $this->package ) . '-' . $handle;

			$path = $this->url( "{$this->asset_dir}/{$path}" );
		}

		$valid = str_starts_with( $path, '//' )
		|| filter_var( $path, FILTER_VALIDATE_URL );

		if ( ! $valid ) {
			return $handle;
		}
		/**
		 * Enqueue script
		 */
		wp_register_script(
			$handle,
			$path,
			apply_filters( "{$this->package}_{$handle}_script_dependencies", $dependencies ),
			$version,
			$in_footer
		);

		return $handle;
	}
}
