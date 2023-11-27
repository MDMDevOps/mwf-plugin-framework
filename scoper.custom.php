<?php

function customize_php_scoper_config( array $config ): array
{
    $wpify = include dirname(__DIR__, 1) . '/vendor/wpify/scoper/symbols/wordpress.php';

    $config[ 'exclude-functions' ] = $wpify[ 'expose-functions' ];

    $config['patchers'] = [
        static function (string $filePath, string $prefix, string $content): string {
            //
            // PHP-Parser patch conditions for file targets
            //
            // var_dump($filePath);
            // echo str_contains( $filePath, 'source/vendor/php-di/php-di/src/Container.php' ) ? 'Yes' : ' No';
            if (str_contains( $filePath, "Container.php" ) ) {
                // echo $filePath;
            }
            if (str_contains( strtolower( $filePath ), strtolower( "source/vendor/php-di/php-di/src/Container.php" ) ) ) {
                // print_r( $filePath );
                return str_replace( 'private', 'protected', $content );
            }
            
            // echo str_contains( $filePath, '/php-di/src/Container.php' ) . ' : ' . ' File' . '\b';
           
            // if ( str_contains( $filePath, 'php-di/src/Container.php' ) ) {
            //     echo $filePath;
            // }
            // if ($filePath === '/path/to/offending/file') {
            //     return preg_replace(
            //         "%\$class = 'Humbug\\\\Format\\\\Type\\\\' . \$type;%",
            //         '$class = \'' . $prefix . '\\\\Humbug\\\\Format\\\\Type\\\\\' . $type;',
            //         $content
            //     );
            // }

            return $content;
        },
    ];

    return $config;
}