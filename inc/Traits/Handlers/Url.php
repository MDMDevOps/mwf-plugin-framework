<?php
/**
 * URL Handler definition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib\Traits\Handlers;

use Mwf\Lib\Deps\DI\Attribute\Inject;

/**
 * URL Handler Trait
 *
 * Allows classes that use this trait to work with URL helpers
 *
 * @subpackage Traits
 */
trait Url
{
	/**
	 * URL to plugin instance
	 *
	 * @var string
	 */
	protected string $url = '';
	/**
	 * Set the base URL
	 * Can include an additional string for appending to the URL of the plugin
	 *
	 * @param string $url : root directory to use.
	 *
	 * @return void
	 */
	#[Inject]
	public function setUrl( #[Inject( 'app.url' )] string $url ): void
	{
		$this->url = $this->appendUrl( $url );
	}
	/**
	 * Get the url with string appended
	 *
	 * @param string $append : string to append to the URL.
	 *
	 * @return string complete url
	 */
	public function url( string $append = '' ): string
	{
		return $this->appendUrl( $this->url, $append );
	}
	/**
	 * Append string safely to end of a url
	 *
	 * @param string $base : the base url.
	 * @param string $append : the string to append.
	 *
	 * @return string
	 */
	protected function appendUrl( string $base, string $append = '' ): string
	{
		return ! empty( $append )
			? untrailingslashit( trailingslashit( $base ) . ltrim( $append, '/' ) )
			: untrailingslashit( $base );
	}
}
