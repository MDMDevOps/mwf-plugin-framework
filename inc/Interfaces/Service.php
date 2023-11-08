<?php
/**
 * Service interface definition
 *
 * PHP Version 8.0.28
 *
 * @package Mwf\Wp\Lib
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\Lib\Interfaces;

/**
 * Service interface
 *
 * Used to type hint against Mwf\Wp\Lib\Interfaces\Service.
 *
 * @subpackage Interfaces
 */
interface Service
{
	/**
	 * Setter for the $enabled flag
	 *
	 * Only set enabled if not previously set. This allows child classes to not
	 * be overridden by parents.
	 *
	 * @param boolean $enabled bool value to set if class is enabled.
	 *
	 * @return bool
	 */
	public function setEnabled( bool $enabled ): bool;
	/**
	 * Getter for enabled flag
	 *
	 * @return bool
	 */
	public function isEnabled(): bool;
}
