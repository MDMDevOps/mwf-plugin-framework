<?php
/**
 * Route Controller
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
	Mwf\Lib\Abstracts,
	Mwf\Lib\Interfaces,
	Mwf\Lib\Routes as Route;

/**
 * Controls the registration and execution of Routes
 *
 * @subpackage Controllers
 */
class Routes extends Abstracts\Mountable implements Interfaces\Controller
{
	/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return [
			'route.frontend' => ContainerBuilder::autowire( Route\Frontend::class ),
			'route.admin'    => ContainerBuilder::autowire( Route\Frontend::class ),
			'route.login'    => ContainerBuilder::autowire( Route\Frontend::class ),
		];
	}
}
