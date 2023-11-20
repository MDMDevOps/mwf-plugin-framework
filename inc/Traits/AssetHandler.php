<?php
/**
 * Asset Handler trait definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Wp\App\Traits;

use DI\Attribute\Inject;

/**
 * URL Handler Trait
 *
 * Allows classes that use this trait to work with URL helpers
 *
 * @subpackage Traits
 */
trait AssetHandler
{
	/**
	 * Relative path to the asset dir
	 *
	 * @var string
	 */
	protected string $asset_dir = 'dist';
	/**
	 * Setter for the asset directory
	 *
	 * @param string $directory : path to the assets directory.
	 *
	 * @return void
	 */
	#[Inject]
	public function setAssetDir( #[Inject( 'app.assets.dir' )] string $directory = 'dist' ): void
	{
		$this->asset_dir = untrailingslashit( ltrim( $directory, '/' ) );
	}
}
