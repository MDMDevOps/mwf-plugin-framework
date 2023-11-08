<?php
/**
 * Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package Mwf\Wp\Lib
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\Lib\Abstracts;

use Mwf\Wp\Lib\Interfaces,
	Mwf\Wp\Lib\Traits;

/**
 * Route class
 *
 * @subpackage Route
 */
abstract class Route extends Service implements Interfaces\Route, Interfaces\Uses\Styles, Interfaces\Uses\Scripts
{
	use Traits\Uses\Styles;
	use Traits\Uses\Scripts;
}
