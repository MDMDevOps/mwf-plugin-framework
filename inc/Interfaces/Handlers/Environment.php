<?php
/**
 * Environment Handler interface definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Interfaces\Handlers;

/**
 * Handlers\Environment interface
 *
 * Used to type hint against Mwf\Lib\Interfaces\Handlers\Environment.
 *
 * @subpackage Interfaces
 */
interface Environment
{
	/**
	 * Set the environment type
	 *
	 * @return void
	 */
	public function setEnvironment(): void;
	/**
	 * Quickly check if in dev environment
	 *
	 * @return bool
	 */
	public function isDev(): bool;
	/**
	 * Check if a particular plugin is active and present in the environment
	 *
	 * @param string $plugin : dir/name.php of the plugin to check.
	 *
	 * @return bool
	 */
	public function isPluginActive( string $plugin ): bool;
}
