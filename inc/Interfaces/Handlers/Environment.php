<?php
/**
 * Environment Handler interface definition
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace MWF\Plugin\Interfaces\Handlers;

/**
 * Handlers\Environment interface
 *
 * Used to type hint against MWF\Plugin\Interfaces\Handlers\Environment.
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
