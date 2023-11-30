<?php
/**
 * Login Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Routes;

use Mwf\Lib\Abstracts,
	Mwf\Lib\Traits,
	Mwf\Lib\Interfaces,
	Mwf\Lib\DI\OnMount;

/**
 * Login router class
 *
 * @subpackage Route
 */
class Login extends Abstracts\Mountable implements Interfaces\Uses\ScriptDispatcher, Interfaces\Uses\StyleDispatcher
{
	use Traits\Uses\ScriptDispatcher;
	use Traits\Uses\StyleDispatcher;

	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * @return void
	 */
	#[OnMount]
	public function mount(): void
	{
		add_action( 'login_enqueue_scripts', [ $this, 'enqueueAssets' ] );
	}
	/**
	 * Enqueue admin styles and JS bundles
	 *
	 * @return void
	 */
	public function enqueueAssets(): void
	{
		$this->enqueueScript(
			'login',
			'login/bundle.js'
		);
		$this->enqueueStyle(
			'login',
			'login/bundle.css'
		);
	}
}
