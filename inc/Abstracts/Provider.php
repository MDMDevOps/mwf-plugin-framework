<?php
/**
 * Provider definition file
 *
 * Providers interface with 3rd party plugins
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
 * Abstract provider class
 *
 * @subpackage Abstracts
 */
abstract class Provider extends Service implements Interfaces\Provider, Interfaces\Handlers\Environment
{
	use Traits\EnvironmentHandler;
}
