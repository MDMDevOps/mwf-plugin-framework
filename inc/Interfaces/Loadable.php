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

namespace Mwf\Wp\App\Interfaces;

/**
 * Loadable interface requirements
 *
 * Used to type hint against Mwf\Wp\App\Interfaces\Loadable.
 *
 * @subpackage Interfaces
 */
interface Loadable
{
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * @return void
	 */
	public function load(): void;
	/**
	 * Perform all functionality required to run when a class loads
	 *
	 * @return void
	 */
	public function onLoad(): void;
	/**
	 * Check if loading action has already fired
	 *
	 * @return int
	 */
	public function hasLoaded(): int;
	/**
	 * Set the name of the package this class belongs to
	 *
	 * @param string $package : string name of the package.
	 *
	 * @return void
	 */
	public function setPackage( string $package ): void;
}
