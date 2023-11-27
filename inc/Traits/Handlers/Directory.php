<?php
/**
 * Directory Handler definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Traits\Handlers;

use Mwf\Lib\Deps\DI\Attribute\Inject;

/**
 * Directory Handler Trait
 *
 * Allows classes that use this trait to work with directory helpers
 *
 * @subpackage Traits
 */
trait Directory
{
	/**
	 * Directory path to plugin instance
	 *
	 * @var string
	 */
	protected string $dir = '';
	/**
	 * Set the base directory - relative to the main plugin file
	 *
	 * Can include an additional string, to make it relative to a different file
	 *
	 * @param string $dir : root path of the plugin.
	 *
	 * @return void
	 */
	#[Inject]
	public function setDir( #[Inject( 'app.dir' )] string $dir ): void
	{
		$this->dir = $this->appendDir( $dir );
	}
	/**
	 * Get the directory path with string appended
	 *
	 * @param string $append : string to append to the directory path.
	 *
	 * @return string complete url
	 */
	public function dir( string $append = '' ): string
	{
		return $this->appendDir( $this->dir, $append );
	}
	/**
	 * Append string safely to end of a Directory
	 *
	 * @param string $base : the base directory path.
	 * @param string $append : the string to append.
	 *
	 * @return string
	 */
	protected function appendDir( string $base, string $append = '' ): string
	{
		return ! empty( $append )
			? untrailingslashit( trailingslashit( $base ) . ltrim( $append, '/' ) )
			: untrailingslashit( $base );
	}
}
