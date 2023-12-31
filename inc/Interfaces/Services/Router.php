<?php
/**
 * Router Service interface definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Interfaces\Services;

/**
 * Services\Router interface
 *
 * Used to type hint against Mwf\Lib\Interfaces\Services\Router.
 *
 * @subpackage Interfaces
 */
interface Router
{
	/**
	 * Getter for views
	 *
	 * @return array<int, string>
	 */
	public function getRoutes(): array;
	/**
	 * Load route specific functionality
	 *
	 * @return void
	 */
	public function loadRoute(): void;
}
