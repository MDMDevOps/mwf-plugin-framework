<?php
/**
 * Dispatcher Controller
 *
 * PHP Version 8.0.28
 *
 * @package Mwf\Wp\Lib
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\Lib\Controllers;

use Mwf\Wp\Lib\DI\ContainerBuilder,
	Mwf\Wp\Lib\Dispatchers as Dispatcher,
	Mwf\Wp\Lib\Interfaces,
	Mwf\Wp\Lib\Abstracts;

/**
 * Controls the registration and execution of Dispatchers
 *
 * @subpackage Controllers
 */
class Dispatchers extends Abstracts\Controller
{
	/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return [
			/**
			 * Class Aliases
			 */
			Dispatcher\Styles::class => ContainerBuilder::autowire(),
			Dispatcher\Scripts::class => ContainerBuilder::autowire(),
			/**
			 * Interfaces
			 */
			Interfaces\Dispatchers\Styles::class => ContainerBuilder::get( Dispatcher\Styles::class ),
			Interfaces\Dispatchers\Scripts::class => ContainerBuilder::get( Dispatcher\Scripts::class ),

		];
	}
}
