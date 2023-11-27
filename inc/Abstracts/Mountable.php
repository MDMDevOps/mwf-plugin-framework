<?php
/**
 * Member definition file
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
	Mwf\Lib\DI\OnMount;

/**
 * Abstract Loadable class
 *
 * @subpackage Abstracts
 */
abstract class Mountable extends Member implements Interfaces\Mountable
{
	/**
	 * Name of class converted to usable slug
	 *
	 * Fully qualified class name, converted to lowercase with forward slashes
	 *
	 * @var string
	 */
	protected string $slug = '';
    /**
     * Getter for slug field
     *
     * @return string
     */
    protected function slug(): string
    {
		if ( ! isset( $this->slug ) ) {
			$this->slug = strtolower( str_replace( [ '\\', '/', ' ' ], '_', static::class ) );
		}
        return $this->slug;
    }
	/**
	 * Check if loading action has already fired
	 *
	 * @return int
	 */
	public function hasMounted(): int
	{
		return did_action( "{$this->slug()}_mounted" );
	}
	/**
	 * Fire Mounted action on mount
	 *
	 * @return void
	 */
	#[OnMount( priority : PHP_INT_MAX )]
	public function onMount(): void
	{
		if ( ! $this->hasMounted() ) {
			do_action( "{$this->slug()}_mounted" );
		}
	}
}
