<?php
/**
 * Factory devinition
 *
 * PHP Version 8.0.28
 *
 * @package App
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-plugin-framework
 * @since   1.0.0
 */

namespace Mwf\Lib;

/**
 * App Factory
 *
 * @subpackage Utilities
 */
class Factory
{
    public static function create( string $class, string $package = '', string $root_file = '' ) {
        require_once trailingslashit( dirname( __DIR__, 1 ) ) . 'deps/autoload.php';
        
        $app = new $class( $package, $root_file );
        
        if ( is_subclass_of( $app, Main::class ) ) {
            $app->mount();
        }
        
        return $app;
    }
}