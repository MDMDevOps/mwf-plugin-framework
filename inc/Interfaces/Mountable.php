<?php
/**
 * Loadable interface definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Interfaces;

/**
 * Loadable interface requirements
 *
 * Used to type hint against Mwf\Lib\Interfaces\Loadable.
 *
 * @subpackage Interfaces
 */
interface Mountable
{
	/**
	 * Check if loading action has already fired
	 *
	 * @return int
	 */
	public function hasMounted(): int;
	/**
	 * Fire Mounted action on mount
	 *
	 * @return void
	 */
	public function onMount(): void;
}
