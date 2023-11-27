<?php
/**
 * Dispatcher Controller
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Controllers;

use Mwf\Lib\DI\ContainerBuilder,
	Mwf\Lib\Dispatchers as Dispatcher,
	Mwf\Lib\Interfaces,
	Mwf\Lib\Abstracts;

/**
 * Controls the registration and execution of Dispatchers
 *
 * @subpackage Controllers
 */
class Dispatchers extends Abstracts\Mountable implements Interfaces\Controller
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
			Dispatcher\Styles::class              => ContainerBuilder::autowire(),
			Dispatcher\Scripts::class             => ContainerBuilder::autowire(),
			/**
			 * Interfaces
			 */
			Interfaces\Dispatchers\Styles::class  => ContainerBuilder::get( Dispatcher\Styles::class ),
			Interfaces\Dispatchers\Scripts::class => ContainerBuilder::get( Dispatcher\Scripts::class ),

		];
	}
}
