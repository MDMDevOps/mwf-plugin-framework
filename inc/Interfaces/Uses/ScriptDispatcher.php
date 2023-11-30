<?php
/**
 * Used Scripts interface definition
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

use Mwf\Lib\Interfaces;

/**
 * Uses\Scripts interface
 *
 * Used to type hint against Mwf\Lib\Interfaces\Uses\Scripts.
 *
 * @subpackage Interfaces
 */
interface ScriptDispatcher
{
	/**
	 * Setter for the script dispatcher
	 *
	 * @param Interfaces\Dispatchers\Scripts $script_dispatcher : instance of script dispatcher.
	 *
	 * @return void
	 */
	public function setScriptDispatcher( Interfaces\Dispatchers\Scripts $script_dispatcher ): void;
	/**
	 * Getter for the script dispatcher
	 *
	 * @return Interfaces\Dispatchers\Scripts|null
	 */
	public function getScriptDispatcher(): ?Interfaces\Dispatchers\Scripts;
	/**
	 * Register a JS file with WordPress
	 *
	 * @param string             $handle : handle to register.
	 * @param string             $path : relative path to script.
	 * @param array<int, string> $dependencies : any set dependencies not in assets file, optional.
	 * @param string             $version : version of JS file, optional.
	 * @param boolean            $in_footer : whether to enqueue in footer, optional.
	 *
	 * @return void
	 */
	public function enqueueScript(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = '',
		$in_footer = true
	): void;
}
