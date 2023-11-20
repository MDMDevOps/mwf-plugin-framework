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
interface Scripts
{
	/**
	 * Setter for the script handler
	 *
	 * @param Dispatchers\Scripts $script_handler : instance of script dispatcher.
	 *
	 * @return void
	 */
	public function setScriptHandler( Dispatchers\Scripts $script_handler ): void;
	/**
	 * Getter for the script handler
	 *
	 * @return Dispatchers\Scripts|null
	 */
	public function getScriptHandler(): ?Dispatchers\Scripts;
}
