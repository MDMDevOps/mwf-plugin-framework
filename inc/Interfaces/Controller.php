<?php
/**
 * Controller interface definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\App\Interfaces;

/**
 * Define controller requirements
 *
 * @subpackage Interfaces
 */

interface Controller
{
	/**
	 * Undocumented function
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array;
}
