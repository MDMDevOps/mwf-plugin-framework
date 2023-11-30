<?php
/**
 * Script User definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Traits\Uses;

use Mwf\Lib\Deps\DI\Attribute\Inject,
	Mwf\Lib\Interfaces;

/**
 * Script Trait
 *
 * Used by classes to import the script dispatcher
 *
 * @subpackage Traits
 */
trait ScriptDispatcher
{
	/**
	 * Script handler instance
	 *
	 * @var Interfaces\Dispatchers\Scripts|null
	 */
	protected ?Interfaces\Dispatchers\Scripts $script_dispatcher;
	/**
	 * Setter for the script dispatcher
	 *
	 * @param Interfaces\Dispatchers\Scripts $script_dispatcher : instance of script dispatcher.
	 *
	 * @return void
	 */
	#[Inject]
	public function setScriptDispatcher( Interfaces\Dispatchers\Scripts $script_dispatcher ): void
	{
		$this->script_dispatcher = $script_dispatcher;
	}
	/**
	 * Getter for the script dispatcher
	 *
	 * @return Interfaces\Dispatchers\Scripts|null
	 */
	public function getScriptDispatcher(): ?Interfaces\Dispatchers\Scripts
	{
		return $this->script_dispatcher;
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
	 * @return void
	 */
	public function enqueueScript(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = '',
		$in_footer = true
	): void {
		$this->script_dispatcher->enqueue(
			$handle,
			$path,
			$dependencies,
			$version,
			$in_footer
		);
	}
}
