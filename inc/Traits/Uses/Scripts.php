<?php
/**
 * Use Script Handler trait definition
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

use Mwf\Lib\Interfaces;

use DI\Attribute\Inject;

/**
 * Trait to define functionality to use a script handler
 *
 * @subpackage Traits
 */
trait Scripts
{
	/**
	 * Script handler instance
	 *
	 * @var Interfaces\Dispatchers\Scripts|null
	 */
	protected ?Interfaces\Dispatchers\Scripts $script_handler;
	/**
	 * Setter for the script handler
	 *
	 * @param Interfaces\Dispatchers\Scripts $script_handler : instance of script dispatcher.
	 *
	 * @return void
	 */
	#[Inject]
	public function setScriptHandler( Interfaces\Dispatchers\Scripts $script_handler ): void
	{
		$this->script_handler = $script_handler;
	}
	/**
	 * Getter for the script handler
	 *
	 * @return Interfaces\Dispatchers\Scripts|null
	 */
	public function getScriptHandler(): ?Interfaces\Dispatchers\Scripts
	{
		return $this->script_handler;
	}
}
