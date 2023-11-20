<?php
/**
 * Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Abstracts;

use Mwf\Lib\Interfaces,
	Mwf\Lib\Traits;

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
