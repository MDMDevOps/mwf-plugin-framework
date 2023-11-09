<?php
/**
 * Frontend Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package Mwf\Wp
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\Routes;

use Mwf\Wp\Abstracts;

/**
 * Frontend router class
 *
 * @subpackage Route
 */
class Frontend extends Abstracts\Route
{
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueueAssets' ] );
	}
	/**
	 * Enqueue admin styles and JS bundles
	 *
	 * @return void
	 */
	public function enqueueAssets(): void
	{
		$this->script_handler->enqueue(
			'frontend',
			'frontend/bundle.js'
		);
		$this->style_handler->enqueue(
			'frontend',
			'frontend/bundle.css'
		);
	}
}
