<?php
/**
 * Use Style Handler trait definition
 *
 * PHP Version 8.0.28
 *
 * @package Mwf\Wp
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\Traits\Uses;

use Mwf\Wp\Interfaces;

use DI\Attribute\Inject;

/**
 * Trait to define functionality to use a style handler
 *
 * @subpackage Traits
 */
trait Styles
{
	/**
	 * Style handler service instance
	 *
	 * @var Interfaces\Dispatchers\Styles|null
	 */
	protected ?Interfaces\Dispatchers\Styles $style_handler;
	/**
	 * Setter for the style handler
	 *
	 * @param Interfaces\Dispatchers\Styles $style_handler : instance of style dispatcher.
	 *
	 * @return void
	 */
	#[Inject]
	public function setStyleHandler( Interfaces\Dispatchers\Styles $style_handler ): void
	{
		$this->style_handler = $style_handler;
	}
	/**
	 * Getter for style handler
	 *
	 * @return Interfaces\Dispatchers\Styles|null
	 */
	public function getStyleHandler(): ?Interfaces\Dispatchers\Styles
	{
		return $this->style_handler;
	}
}
