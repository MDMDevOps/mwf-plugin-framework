<?php
/**
 * Directory Handler interface definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace App\Interfaces\Handlers;

/**
 * Handlers\Directory interface
 *
 * Used to type hint against App\Interfaces\Handlers\Directory.
 *
 * @subpackage Interfaces
 */
interface Directory
{
	/**
	 * Set the base directory - relative to the main plugin file
	 *
	 * Can include an additional string, to make it relative to a different file
	 *
	 * @param string $root : root path of the plugin.
	 * @param string $append : string to append to base directory path.
	 *
	 * @return void
	 */
	public function setDir( string $root, string $append = '' ): void;
	/**
	 * Get the directory path with string appended
	 *
	 * @param string $append : string to append to the directory path.
	 *
	 * @return string complete url
	 */
	public function dir( string $append = '' ): string;
}
