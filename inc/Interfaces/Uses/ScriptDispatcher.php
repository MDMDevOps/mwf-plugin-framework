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

use Mwf\Lib\Interfaces\Dispatchers;

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
	 * Setter for the script handler
	 *
	 * @param Dispatchers\Scripts $script_handler : instance of script dispatcher.
	 *
	 * @return void
	 */
	public function setScriptDispatcher( Dispatchers\Scripts $script_handler ): void;
	/**
	 * Getter for the script handler
	 *
	 * @return Dispatchers\Scripts|null
	 */
	public function getScriptDispatcher(): ?Dispatchers\Scripts;
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
	public function enqueueScript(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = '',
		$in_footer = true
	): void;
}
