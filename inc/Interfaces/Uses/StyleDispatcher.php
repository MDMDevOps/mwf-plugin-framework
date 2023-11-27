<?php
/**
 * Uses Styles interface definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Interfaces\Uses;

use Mwf\Lib\Interfaces\Dispatchers;

/**
 * Uses\Styles interface
 *
 * Used to type hint against Mwf\Lib\Interfaces\Uses\Styles.
 *
 * @subpackage Interfaces
 */
interface StyleDispatcher
{
	/**
	 * Setter for the style handler
	 *
	 * @param Dispatchers\Styles $style_handler : instance of style dispatcher.
	 *
	 * @return void
	 */
	public function setStyleDispatcher( Dispatchers\Styles $style_handler ): void;
	/**
	 * Getter for style handler
	 *
	 * @return Dispatchers\Styles|null
	 */
	public function getStyleDispatcher(): ?Dispatchers\Styles;
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
	public function enqueueStyle(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = null,
		$screens = 'all'
	): void;
}
