<?php
/**
 * Uses Styles interface definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\App\Interfaces\Uses;

use Mwf\Wp\App\Interfaces\Dispatchers;

/**
 * Uses\Styles interface
 *
 * Used to type hint against Mwf\Wp\App\Interfaces\Uses\Styles.
 *
 * @subpackage Interfaces
 */
interface Styles
{
	/**
	 * Setter for the style handler
	 *
	 * @param Dispatchers\Styles $style_handler : instance of style dispatcher.
	 *
	 * @return void
	 */
	public function setStyleHandler( Dispatchers\Styles $style_handler ): void;
	/**
	 * Getter for style handler
	 *
	 * @return Dispatchers\Styles|null
	 */
	public function getStyleHandler(): ?Dispatchers\Styles;
}
