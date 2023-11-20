<?php
/**
 * Asset Handler interface definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\Interfaces\Handlers;

/**
 * Handlers\Assets interface
 *
 * Used to type hint against Mwf\Wp\Interfaces\Handlers\Assets.
 *
 * @subpackage Interfaces
 */
interface Assets
{
	/**
	 * Setter for the asset directory
	 *
	 * @param string $directory : path to the assets directory.
	 *
	 * @return void
	 */
	public function setAssetDir( string $directory ): void;
}
