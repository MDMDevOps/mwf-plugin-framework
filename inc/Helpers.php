<?php
/**
 * Helper Functions
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
class Helpers
{
	public static function anySub( string|object $instance_or_class, string $needle ): bool
	{

		$class_name = is_object( $instance_or_class ) ? get_class( $instance_or_class ) : $instance_or_class;

		if ( ! class_exists( $class_name ) ) {
			return false;
		}

		$uses = match ( true ) {
			is_subclass_of( $instance_or_class, $needle ) => true,
            self::implements( $instance_or_class, $needle ) => true,
            self::uses( $instance_or_class, $needle ) => true,
			default => false
		};

		return $uses;
	}

    public static function uses( string|object $instance_or_class, string $needle ): bool
    {
        $class_name = is_object( $instance_or_class ) ? get_class( $instance_or_class ) : $instance_or_class;
        
		if ( ! class_exists( $class_name ) ) {
			return false;
		}
        return in_array( $needle, self::getTraits( $class_name ), true );
    }

    public static function implements( string|object $instance_or_class, string $needle ): bool
    {
        $class_name = is_object( $instance_or_class ) ? get_class( $instance_or_class ) : $instance_or_class;

		if ( ! class_exists( $class_name ) ) {
			return false;
		}
        return in_array( $needle, class_implements( $class_name ), true );
    }

	public static function getTraits( $instance_or_class )
    {
        $class_name = is_object( $instance_or_class ) ? get_class( $instance_or_class ) : $instance_or_class;

        if ( ! class_exists( $class_name ) ) {
			return [];
		}

        $traits = self::classUses( $class_name );

        $parents = class_parents( $class_name );

        if ( ! empty( $parents ) ) {
            foreach ( $parents as $parent ) {
                $traits += self::classUses( $parent );
            }
        }
        return array_unique( $traits );
    }

    public static function classUses( string|object $instance_or_class ): array
    {
        $class_name = is_object( $instance_or_class ) ? get_class( $instance_or_class ) : $instance_or_class;

        if ( ! class_exists( $class_name ) ) {
			return [];
		}

        $traits = class_uses( $class_name );

        return ! empty( $traits ) ? $traits : [];
    }
    /**
     * Wrapper to call functions from twig
     *
     * @param mixed ...$args : all arguments passed, unknown.
     *
     * @return mixed
     */
    public function doFunction( ...$args )
    {
        $function = array_shift( $args );
        ob_start();
        try {
            $output  = is_callable( $function ) ? call_user_func( $function, ...$args ) : null;
            $content = ob_get_clean();
            return $output ?? $content;
        } catch ( \Error $e ) {
            return null;
        }
    }
}
